<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    // This refreshes the accessToken that is required to run any other API call
    static function refreshDataAccess() {
        $authorization = base64_encode("".env('SPOTIFY_CLIENT_ID').":".env('SPOTIFY_CLIENT_SECRET'));

        $response = Http::asForm()->withHeaders([
            'Authorization' => 'Basic '.$authorization,
        ])->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => session('refreshToken'),
        ]);

        $responseJSON = $response->json();

        session(['accessToken' => $responseJSON['access_token']]);
    }

    // Gets a users top 50 tracks/artists depending on which route was used
    function getTop($type) {

        $range = isset($_GET['t']) ? $_GET['t'] : "short_term";
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('accessToken'),
        ])->get('https://api.spotify.com/v1/me/top/'.$type.'?time_range='.$range.'&limit=50');
        
        $data = $response->json();

        if(isset($data['error']['status'])) {
            if($data['error']['status'] == '401') {
                DataController::refreshDataAccess();
                return $this->getTop($type);
            }
        }
        return view('top')->with(['items' => $data['items'], 'type' => $type, 'range' => $range]);
    }

    // Gets a user reccommended tracks based upon their top artists
    function getReccommendations() {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('accessToken'),
        ])->get('https://api.spotify.com/v1/me/top/'.$type.'?time_range='.$range.'&limit=50');
        
        $data = $response->json();

        return view('top')->with(['items' => $data['items'], 'type' => $type, 'range' => $range]);
    }

}
