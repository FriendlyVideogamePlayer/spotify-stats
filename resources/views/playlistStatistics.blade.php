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

    <svg class="" width="800" height="100" role="img">
		<title id="title">Danceability distribution</title>
			<g class="">
				@foreach($danceabilityVals as $item) { 
					@php ($result = 800 / $maxVals[0][0])
					@php ($tempoVal = $item[0] * $result)
                    <rect width="1" height="100" x="{{$tempoVal}}"></rect>
                @endforeach
			</g>
	</svg>
</div>
</body>
@include('components.footer')
</html>