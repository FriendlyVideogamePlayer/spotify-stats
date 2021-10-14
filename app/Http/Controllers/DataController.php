<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Session;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{


    /**
     * Refreshes the accessToken that is required to run any other API call and overwrites the current value in the session
     *
     */
    function refreshDataAccess(): void
    {
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

    /**
     * Gets a users top 50 tracks/artists depending on which route was visited
     * Also checks if a time query string exists and uses it in the api call if it does
     *
     * @param $type
     * @return View
     */
    function getTop($type)
    {
        if(!Session::has('accessToken')) {
            return redirect('/');
        }
        if(!Session::has('username')) {
            $this->getDisplayInfo();
        }

        $range = isset($_GET['t']) ? $_GET['t'] : "short_term";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('accessToken'),
        ])->get('https://api.spotify.com/v1/me/top/'.$type.'?time_range='.$range.'&limit=50');

        $data = $response->json();

        if(isset($data['error']['status'])) {
            if($data['error']['status'] == '401' || $data['error']['status'] == '400') {
                $this->refreshDataAccess();
                return $this->getTop($type);
            }
        }
        // Use the top tracks or artists as seeds for the recommended tracks function that might be accessed later
        $recommendedSeeds = [];
        $i = 0;

        while($i < 5) {
            if($type == 'artists') {
                $artistId = $data['items'][$i]['id'];
            }
            elseif($type == 'tracks') {
                $artistId = $data['items'][$i]['artists']['0']['id'];
            }
            array_push($recommendedSeeds, $artistId);
            $i++;
        }

        session(['recommendedSeeds' => implode('%2C', $recommendedSeeds)]);

        return view('dataDisplay')->with(['items' => $data['items'], 'type' => $type, 'range' => $range]);
    }


    /**
     * Gets a users recommended tracks based upon their top artists using the seeds from the above function and returns the recommendations view to display them
     *
     * @return View|RedirectResponse
     */
    function getRecommendations()
    {
        if(!Session::has('accessToken')) {
            return redirect('/');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('accessToken'),
        ])->get('https://api.spotify.com/v1/recommendations?limit=50&seed_artists='.session('recommendedSeeds'));

        $data = $response->json();

        if(isset($data['error']['status'])) {
            if($data['error']['status'] == '401' || $data['error']['status'] == '400') {
                $this->refreshDataAccess();
                return $this->getRecommendations();
            }
        }

        return view('dataDisplay')->with(['items' => $data['tracks'], 'type' => 'recommendations']);
    }


    /**
     * Gets a user's spotify display name and image to display in the navbar
     *
     */
    function getDisplayInfo(): void
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('accessToken'),
        ])->get('https://api.spotify.com/v1/me');

        $data = $response->json();

        session(['username' => $data['display_name']]);

        if(isset($data['images']['0']['url']) ) {
            session(['userImage' => $data['images']['0']['url']]);
        } else {
            session(['userImage' => "Images/noArtist.jpg"]);
        }
    }

    /**
     * Gets a list of all playlists a user follows or owns, returns the playlist selector view with all the playlists inserted into a select
     *
     * @param null $offset
     * @return RedirectResponse|View
     */
    function getPlaylists($offset = null)
    {
        if(!Session::has('accessToken')) {
            return redirect('/');
        }

        $offsetVal = ($offset !== null) ? $offset : 0;
        $offset = $offsetVal;

        if($offsetVal == 0 && Session('playlistIds') !== null ) {
            Session::forget('playlistIds');
            session(['playlistIds' => []]);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('accessToken'),
        ])->get('https://api.spotify.com/v1/me/playlists?limit=50&offset='.$offsetVal);

        $data = $response->json();

        $offset += 50;

        if(isset($data['error']['status'])) {
            if($data['error']['status'] == '401' || $data['error']['status'] == '400') {
                $this->refreshDataAccess();
                return $this->getPlaylists($offset);
            }
        }

        $playlistCount = $data['total'];

        foreach($data['items'] as $item) {
            $playlistData = [];
            array_push($playlistData, $item['name'], $item['id']);
            Session::push('playlistIds', $playlistData);
        }
        // recursively call ourself to grab all of the available playlists to a cap of 100
        if($offset < $playlistCount && $offset < 100) {
            return $this->getPlaylistTracks($offset);
        }

        return view('playlists')->with(['items' => session('playlistIds')]);
    }

    /**
     * Gets all of the tracks within a specified playlist
     *
     * @param $playlistId
     * @param null $offset
     * @return RedirectResponse|View
     */
    function getPlaylistTracks($playlistId, $offset = null)
    {
        if(!Session::has('accessToken')) {
            return redirect('/');
        }

        $offsetVal = ($offset !== null) ? $offset : 0;
        $offset = $offsetVal;

        // clear the values if this is a clean call of the function but it was used before so as not to have multiple playlists data used when we only want one
        if($offsetVal == 0 && Session('artistNames') !== null ) {
            Session::forget('trackIds');
            session(['trackIds' => []]);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('accessToken'),
        ])->get('https://api.spotify.com/v1/playlists/'.$playlistId.'/tracks?fields=items(track(id%2Cname%2Cartists))%2C%20total%2C%20offset%2C%20limit%2C%20next%2C%20previous&limit=100&offset='.$offsetVal);

        $data = $response->json();

        if(isset($data['error']['status'])) {
            if($data['error']['status'] == '401') {
                $this->refreshDataAccess();
                return $this->getPlaylistTracks($playlistId, $offset);
            }
        }

        $trackCount = $data['total'];
        $offset += 100;

        // Take track name and id and pair them in an array
        foreach($data['items'] as $item) {
            $trackData = [];
            array_push($trackData, $item['track']['name']);
            array_push($trackData, $item['track']['id']);
            Session::push('trackIds', $trackData);
        }
        // recursively call ourself to grab all of the available tracks to a cap
        if($offset < $trackCount && $offset < 500) {
            return $this->getPlaylistTracks($playlistId, $offset);
        }
        // Use the playlist selected in the html select
        $selectedPlaylist = array_search($playlistId, array_column(session('playlistIds'), 1));
        session(['selectedPlaylist' => session('playlistIds.'.$selectedPlaylist.'.0')]);

        return $this->getTrackFeatures(0, $trackCount);
    }

    /**
     * Gets the Spotify "features" of a track such as danceability for all tracks within a playlist
     *
     * @param null $offset
     * @param $trackCount
     * @return View
     */
    function getTrackFeatures($offset = null, $trackCount)
    {
        $offsetVal = ($offset !== null) ? $offset : 0;
        $offset = $offsetVal;

        // seperate all the track ids into one comma seperated array
        $slicedTrackIds = [];
        $i = $offset;
        while($i < $offset+100 && $i < $trackCount) {
            array_push($slicedTrackIds, session('trackIds')[$i][1]);
            $i++;
        }
        $trackIdList = implode(',', $slicedTrackIds);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('accessToken'),
        ])->get('https://api.spotify.com/v1/audio-features?ids='.$trackIdList);

        $data = $response->json();

        if(isset($data['error']['status'])) {
            if($data['error']['status'] == '401') {
                $this->refreshDataAccess();
                return $this->getTrackFeatures($offset, $trackCount);
            }
        }
        // clear the values if this is a clean call of the function but it was used before
        if($offset == 0 && session('playlistStats') !== null) {
            Session::forget('playlistStats');
            session(['playlistStats' => []]);
        }
        elseif($offset == 0) {
            session(['playlistStats' => []]);
        }

        // calculate and store each track feature in the playliststats array
        foreach($data['audio_features'] as $item) {
            $duration_ms  = $item['duration_ms'];
			$duration_m = floor($duration_ms / 60000);
			$duration_s = floor(($duration_ms / 1000) % 60);
			$formating = '%02u:%02u';
            $duration = sprintf($formating, $duration_m, $duration_s);

            Session::push('playlistStats.'.$item['id'].'.danceability', $item['danceability']);
            Session::push('playlistStats.'.$item['id'].'.energy', $item['energy']);
            Session::push('playlistStats.'.$item['id'].'.loudness', $item['loudness']);
            Session::push('playlistStats.'.$item['id'].'.tempo', $item['tempo']);
            Session::push('playlistStats.'.$item['id'].'.valence', $item['valence']);
            Session::push('playlistStats.'.$item['id'].'.duration', $duration);
        }

        $offset += 100;
        if($offset < $trackCount && $offset < 500) {
            return $this->getTrackFeatures($offset, $trackCount);
        }

        // Set vars for, and then obtain, max values for each feature and the track id
        $maxDanceability = $maxEnergy = $maxLoudness = $maxTempo = $maxValence = $maxDuration = null;
        $maxDanceabilityKey = $maxEnergyKey = $maxLoudnessKey = $maxTempoKey = $maxValenceKey = $maxDurationKey = null;

        $danceabilityVals = $tempoVals = $valenceVals = [];

		foreach(session('playlistStats') as $key => $value) {
			if (is_null($maxDanceability) || $value['danceability'] > $maxDanceability) {
				$maxDanceability = $value['danceability'];
				$maxDanceabilityKey = $key;
            }
            array_push($danceabilityVals, $value['danceability']);
            if (is_null($maxEnergy) || $value['energy'] > $maxEnergy) {
                $maxEnergy = $value['energy'];
                $maxEnergyKey = $key;
            }
            if (is_null($maxLoudness) || $value['loudness'] > $maxLoudness) {
                $maxLoudness = $value['loudness'];
                $maxLoudnessKey = $key;
            }
            if (is_null($maxTempo) || $value['tempo'] > $maxTempo) {
                $maxTempo = $value['tempo'];
                $maxTempoKey = $key;
            }
            array_push($tempoVals, $value['tempo']);
            if (is_null($maxValence) || $value['valence'] > $maxValence) {
                $maxValence = $value['valence'];
                $maxValenceKey = $key;
            }
            array_push($valenceVals, $value['valence']);
            if (is_null($maxDuration) || $value['duration'] > $maxDuration) {
                $maxDuration = $value['duration'];
                $maxDurationKey = $key;
            }
        }
        $maxVals = [$maxDanceability, $maxEnergy, $maxLoudness, $maxTempo, $maxValence, $maxDuration];
        $danceabilityTrack = session('trackIds.'.array_search($maxDanceabilityKey, array_column(session('trackIds'), 1)).'.0');
        $energyTrack = session('trackIds.'.array_search($maxEnergyKey, array_column(session('trackIds'), 1)).'.0');
        $loudnessTrack = session('trackIds.'.array_search($maxLoudnessKey, array_column(session('trackIds'), 1)).'.0');
        $tempoTrack = session('trackIds.'.array_search($maxTempoKey, array_column(session('trackIds'), 1)).'.0');
        $valenceTrack = session('trackIds.'.array_search($maxValenceKey, array_column(session('trackIds'), 1)).'.0');
        $durationTrack = session('trackIds.'.array_search($maxDurationKey, array_column(session('trackIds'), 1)).'.0');

        $features = [$maxDanceabilityKey, $maxEnergyKey, $maxLoudnessKey, $maxTempoKey, $maxValenceKey, $maxDurationKey];
        $trackLinks = [];
        foreach($features as $feature) {
            array_push($trackLinks,'https://open.spotify.com/track/'.$feature);
        }

        $trackArray = [['fType' => 'danceability', 'feature' => $danceabilityTrack, 'link' => $trackLinks[0], 'max' => $maxVals[0]],['fType' => 'energy', 'feature'=> $energyTrack, 'link' => $trackLinks[1], 'max' => $maxVals[1]],
        ['fType' => 'loudness', 'feature' => $loudnessTrack, 'link' => $trackLinks[2], 'max' => $maxVals[2]], ['fType' => 'tempo', 'feature' => $tempoTrack, 'link' => $trackLinks[3], 'max' => $maxVals[3]],
        ['fType' => 'valence', 'feature' => $valenceTrack, 'link' => $trackLinks[4], 'max' => $maxVals[4]], ['fType' => 'duration', 'feature' => $durationTrack, 'link' => $trackLinks[5], 'max' => $maxVals[5]]];


        return view('playlistStatistics')->with(['trackArray' => $trackArray, 'title' => session('selectedPlaylist'), 'danceabilityVals' =>$danceabilityVals, 'tempoVals' => $tempoVals,
        'valenceVals' => $valenceVals, 'maxVals' => $maxVals]);
    }


    /**
     * Gets the current track a user is listening to on spotify
     *
     * @return RedirectResponse|View
     */
    function getCurrentTrack()
    {
        if(!Session::has('accessToken')) {
            return redirect('/');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('accessToken'),
        ])->get('https://api.spotify.com/v1/me/player/currently-playing');

        $data = $response->json();

        if(isset($data['error']['status'])) {
            if($data['error']['status'] == '401' || $data['error']['status'] == '400') {
                $this->refreshDataAccess();
                return $this->getCurrentTrack();
            }
        }

        if($data == null) {
            return view('dataDisplay')->with(['type' => '204-unavailable']);
        }

        return $this->getRecommendationsFromTrack($data['item']);
    }

    /**
     * Gets recommended tracks from a specified track
     *
     * @param $trackInfo
     * @return RedirectResponse|View
     */
    function getRecommendationsFromTrack($trackInfo) {
        if(!Session::has('accessToken')) {
            return redirect('/');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('accessToken'),
        ])->get('https://api.spotify.com/v1/recommendations?limit=20&seed_tracks='.$trackInfo['id']);

        $data = $response->json();

        if(isset($data['error']['status'])) {
            if($data['error']['status'] == '401' || $data['error']['status'] == '400') {
                $this->refreshDataAccess();
                return $this->getRecommendationsFromTrack();
            }
        }

        return view('dataDisplay')->with(['items' => $data['tracks'], 'type' => 'currentTrack', 'currentTrackInfo' => $trackInfo]);
    }


}
