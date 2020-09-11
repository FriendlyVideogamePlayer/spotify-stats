<html>
@include('components.head')
@include('components.nav')
<body>

<div class="container-fluid">

    <div class="header pb-1">
        Your @if($type !== "recommendations") top @endif {{$type}} 
    </div>

    @include('components.range')

    <div class="card-deck justify-content-center">
        @foreach($items as $item)

            <a href="{{$item['external_urls']['spotify']}}" class="card mb-4 cardAdjust card-home" >
            @if($type == "artists")
                <img class="artistImage card-img-top" src="{{$item['images']['1']['url'] ?? asset('images/noimage.png')}}" alt="Card image cap" style="object-fit: cover;">
            @else
                <img class="artistImage card-img-top" src="{{$item['album']['images']['1']['url'] ?? asset('images/noimage.png')}}" alt="Card image cap">
            @endif
                <div class="extend card-img-overlay overlay">
                    <div class="itemName"> {{$item['name']}} </div>
                </div>
                <div class="card-footer d-md-none">
                    <small class="text-card">{{$item['name']}}</small> <br>
                </div>
            </a>
        @endforeach
    </div>

</div>

</body>
@include('components.footer')
</html>