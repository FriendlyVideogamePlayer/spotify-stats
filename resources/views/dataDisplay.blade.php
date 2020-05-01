<html>
@include('components.head')
@include('components.nav')
<body>

<div class="container-fluid">

    <div class="header">
        Your top {{$type}} 
    </div>

    @include('components.range')

    <div class="card-deck">
        @foreach($items as $item)

            <a href="{{$item['external_urls']['spotify']}}" class="card mb-4 mouseOver" style="min-width: 18rem;">
            @if($type == "artists")
                <img class="card-img-top" src="{{$item['images']['1']['url']}}" alt="Card image cap" style="object-fit: cover;">
            @else
                <img class="card-img-top" src="{{$item['album']['images']['1']['url']}}" alt="Card image cap">
            @endif
                <div class="card-img-overlay overlay">
                    <div class="itemName"> {{$item['name']}} </div>
                </div>
                <div class="card-footer d-md-none">
                    <small class="text-muted">{{$item['name']}}</small> <br>
                </div>
            </a>
        @endforeach
    </div>

</div>

</body>
</html>