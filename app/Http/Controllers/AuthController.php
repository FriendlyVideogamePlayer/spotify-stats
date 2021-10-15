<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    /**
     * Main login function that will redirect to Spotify web authorization flow and then redirect the user to a callback page
     *
     */
    function login(): void
    {
        header('Location: https://accounts.spotify.com/authorize?client_id='.env("SPOTIFY_CLIENT_ID").'&response_type=code&redirect_uri='.env("SPOTIFY_REDIRECT_URI").'&scope=user-read-private%20user-top-read%20playlist-read-private%20playlist-modify-public%20user-read-currently-playing');
        exit;
    }

    /**
     * Callback function after logging in - if the auth succeeded proceed to top tracks page otherwise redirect to home page
     *
     * @return RedirectResponse
     */
    function callback(): RedirectResponse
    {
      if(isset($_GET['code']) ){
        session(['code' => $_GET['code']]);
        $this->getUserCodes();
        return redirect('/toptracks');
      }
      else if(Session::has('accessToken') ){
          return redirect('/toptracks');
      }
      else {
          return redirect('/');
      }
    }

    /**
     * Gets a user's accessToken which is needed in future API calls and a refreshToken which is needed to update the accessToken upon expiry
     *
     * @return RedirectResponse|void
     */
    function getUserCodes()
    {
      $authorization = base64_encode("".env('SPOTIFY_CLIENT_ID').":".env('SPOTIFY_CLIENT_SECRET'));

      $response = Http::asForm()->withHeaders([
          'Authorization' => 'Basic '.$authorization,
      ])->post('https://accounts.spotify.com/api/token', [
          'grant_type' => 'authorization_code',
          'code' => session('code'),
          'redirect_uri' => env("SPOTIFY_REDIRECT_URI"),
      ]);

      $responseJSON = $response->json();

      if(isset($responseJSON['error']['status'])) {
        if($responseJSON['error']['status'] == '401' || $responseJSON['error']['status'] == '400') {
          Session::forget('code');
          return redirect('/');
        }
      }

      session(['accessToken' => $responseJSON['access_token']]);
      session(['refreshToken' => $responseJSON['refresh_token']]);
    }

}
