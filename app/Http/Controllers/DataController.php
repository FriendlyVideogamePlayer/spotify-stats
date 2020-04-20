<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    function getTop($type) {
        $range = "short_term";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('accessToken'),
        ])->get('https://api.spotify.com/v1/me/top/'.$type.'?time_range='.$range.'&limit=50');
        
        $data = $response->json();

        return view('top')->with(['items' => $data['items'], 'type' => $type]);
        echo "<pre>";
        print_r($data);
    }
}
