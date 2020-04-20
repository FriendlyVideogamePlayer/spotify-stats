<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // Main login function that will redirect to Spotify web authorization flow. 
    function login() {
        header('Location: https://accounts.spotify.com/authorize?client_id='.env("SPOTIFY_CLIENT_ID").'&response_type=code&redirect_uri=http%3A%2F%2Flocalhost%2Fspotifystats%2Fpublic%2Fcallback&scope=user-read-private%20user-top-read%20playlist-read-private');
        exit; 
      }
    
      // Callback function after logging in - either take data and proceed to stats or redirect to home page.
      function callback() {
        if(isset($_GET['code']) ){
          session(['code' => $_GET['code']]);
          $this->getUserCodes();
        } 
        else if(Session::has('accessToken') ){
            return redirect('/toptracks');
        } 
        else {
            return redirect('/');
        }
      }
  
      function getUserCodes() {

        $authorization = base64_encode("".env('SPOTIFY_CLIENT_ID').":".env('SPOTIFY_CLIENT_SECRET'));

        $response = Http::asForm()->withHeaders([
            'Authorization' => 'Basic '.$authorization,
        ])->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'authorization_code',
            'code' => session('code'),
            'redirect_uri' => 'http://localhost/spotifystats/public/callback',
        ]);
        
        $responseJSON = $response->json();
        
        session(['accessToken' => $responseJSON['access_token']]);
        session(['refreshToken' => $responseJSON['refresh_token']]); 
        
      }

}
