<html lang="en">
@include('components.head')
@include('components.nav')
<body>

<div class="container-fluid" role="main">
    <div class="playlistHeader pb-1 mb-4">
        Statistics for your playlist "{{$title}}"
    </div>

    <div class="card-deck justify-content-center playlistCardDeck">
            @foreach($trackArray as $item => $value)
                    <div class="card mb-4 cardPlaylist">
                        <div class="card-body">
                            <h5 class="card-title">Track with highest {{$value['fType']}}</h5>
                            <p class="card-text">{{$value['feature']}}</p>
                            <a href="{{$value['link']}}" class="btn btn-primary">Listen on Spotify!</a>
                        </div>
                    </div>
            @endforeach
    </div>

    <div class="card-deck justify-content-center mt-4 deckSvg">
        <div class="card mb-4 cardSvg">
            <div class="card-body">
                <h5 class="card-title playlistTitle">Danceability distribution</h5>
                <svg class="" width="350" height="80" role="img">
                    <title id="title">Danceability distribution</title>
                    <g class="">
                        @foreach($danceabilityVals as $item) { 
                            @php ($danceVal = $item[0] * 350)
                            <rect width="1" height="100" x="{{$danceVal}}"></rect>
                        @endforeach
                    </g>
                </svg>
                <div class="alignDist mb-1">
                    <p class="leftA">Lower</p>
                    <p class="rightA">Higher</p>
                </div>
                <p class="card-text alignDist mt-4">Danceability is a measurement of how danceable Spotify believes a track to be.</p>
            </div>
        </div>

        <div class="card mb-4 cardSvg">
            <div class="card-body">
                <h5 class="card-title playlistTitle">Tempo distribution</h5>
                <svg class="" width="350" height="80" role="img">
                    <title id="title">Tempo distribution</title>
                        <g class="">
                            @foreach($tempoVals as $item) { 
                                @php ($result = 350 / $maxVals[3][0])
                                @php ($tempoVal = $item[0] * $result)
                                <rect width="1" height="100" x="{{$tempoVal}}"></rect>
                            @endforeach
                        </g>
                </svg>
                <div class="alignDist mb-1">
                    <p class="leftA">Lower</p>
                    <p class="rightA">Higher</p>
                </div>
                <p class="card-text alignDist mt-4">Tempo is a measurement of a track's BPM.</p>
            </div>
        </div>
    </div>
    <div class="card-deck justify-content-center my-4 deckSvg">
        <div class="card mb-4 cardSvg">
            <div class="card-body">
                <h5 class="card-title playlistTitle">Valence distribution</h5>
                <svg class="" width="350" height="80" role="img">
                    <title id="title">Valence distribution</title>
                        <g class="">
                            @foreach($valenceVals as $item) { 
                                @php ($valenceVal = $item[0] * 350)
                                <rect width="1" height="100" x="{{$valenceVal}}"></rect>
                            @endforeach
                        </g>
                </svg>
                <div class="alignDist mb-1">
                    <p class="leftA">Lower</p>
                    <p class="rightA">Higher</p>
                </div>
                <p class="card-text alignDist mt-4">Valence is a measurement of how "Positive" a song is. Higher valence songs sound "happier".</p>
            </div>
        </div>
    </div>
</div>
</body>
@include('components.footer')
</html>