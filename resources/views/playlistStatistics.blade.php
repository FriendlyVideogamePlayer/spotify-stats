<html>
@include('components.head')
@include('components.nav')
<body>

<div class="container-fluid">
    <div class="playlistHeader pb-1 mb-4">
        Statistics for your playlist "{{$title}}"
    </div>

    <div class="card-deck justify-content-center playlistCardDeck">
            @foreach($trackArray as $item => $value)
                    <div class="card mb-4 cardPlaylist">
                        <div class="card-body">
                            <h5 class="card-title">Track with highest {{$item}}</h5>
                            <p class="card-text">{{$value}}</p>
                            <!-- <a href="#" class="btn btn-primary">Listen on Spotify!</a> -->
                        </div>
                    </div>
            @endforeach
    </div>

    <div class="card-deck justify-content-center">

            <div class="card mb-4 cardSvg">
                <div class="card-body">
                    <h5 class="card-title">Danceability distribution</h5>
                    <svg class="" width="400" height="80" role="img">
                        <title id="title">Danceability distribution</title>
                        <g class="">
                            @foreach($danceabilityVals as $item) { 
                                @php ($danceVal = $item[0] * 400)
                                <rect width="1" height="100" x="{{$danceVal}}"></rect>
                            @endforeach
                        </g>
                    </svg>
                </div>
            </div>

            

            <div class="card mb-4 cardSvg">
                <div class="card-body">
                    <h5 class="card-title">Tempo distribution</h5>
                    <svg class="" width="400" height="80" role="img">
                        <title id="title">Tempo distribution</title>
                            <g class="">
                                @foreach($tempoVals as $item) { 
                                    @php ($result = 400 / $maxVals[3][0])
                                    @php ($tempoVal = $item[0] * $result)
                                    <rect width="1" height="100" x="{{$tempoVal}}"></rect>
                                @endforeach
                            </g>
                    </svg>
                </div>
            </div>



            <div class="card mb-4 cardSvg">
                <div class="card-body">
                    <h5 class="card-title">Valence distribution</h5>
                    <svg class="" width="400" height="80" role="img">
                        <title id="title">Valence distribution</title>
                            <g class="">
                                @foreach($valenceVals as $item) { 
                                    @php ($valenceVal = $item[0] * 400)
                                    <rect width="1" height="100" x="{{$valenceVal}}"></rect>
                                @endforeach
                            </g>
                    </svg>
                </div>
            </div>


    </div>

</div>
</body>
@include('components.footer')
</html>