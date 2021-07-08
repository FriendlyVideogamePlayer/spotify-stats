<html lang="en">
@include('components.head')
@include('components.nav')
<body>

<div class="container-fluid" role="main">
    @if($type == "currentTrack" || $type == "204-unavailable")
        @include('components.currentTrackDetails')
    @else
        <div class="header pb-1" role="heading" aria-level="1">
            Your @if($type !== "recommendations") top @endif {{$type}} 
        </div>
    @endif

    @include('components.range')

    @if($type !== "204-unavailable")
        <div class="card-deck justify-content-center">
            @foreach($items as $item)

                <a href="{{$item['external_urls']['spotify']}}" class="card mb-4 cardAdjust card-home" >
                @if($type == "artists")
                    <img class="artistImage card-img-top" src="{{$item['images']['1']['url'] ?? asset('images/noimage.png')}}" alt="Album art for - {{$item['name']}}" style="object-fit: cover;">
                @else
                    <img class="artistImage card-img-top" src="{{$item['album']['images']['1']['url'] ?? asset('images/noimage.png')}}" alt="Album art for - {{$item['name']}}">
                @endif
                    <div class="extend card-img-overlay overlay d-sm-none d-lg-block">
                        <div class="itemName"> {{$item['name']}} </div>
                    </div>
                    <div class="card-footer d-lg-none">
                        <small class="text-card">{{$item['name']}}</small> <br>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>

</body>
@include('components.footer')
</html>