<html>
@include('components.head')
@include('components.nav')
<body>

<div class="container-fluid">
    <div class="playlistHeader pb-1 mb-4">
        Statistics for your playlist "{{$title}}"
    </div>

    <div class="card-deck justify-content-center">
        <div class="row">
            @php ($i = 0)
            @foreach($trackArray as $item => $value)
                <div class="col-md-4 col-sm-6">
                    <div class="card mb-4 cardPlaylist">
                        <div class="card-body">
                            <h5 class="card-title">Track with highest {{$item}}</h5>
                            <p class="card-text">{{$value}}</p>
                            <!-- <a href="#" class="btn btn-primary">Listen on Spotify!</a> -->
                        </div>
                    </div>
                </div>
                @if($i == 2)
                    </div>
                    <div class="row">
                @endif
                @if($i == 5)
                    </div>
                @endif
                @php ($i++)
            @endforeach
    </div>
</div>
</body>
@include('components.footer')
</html>