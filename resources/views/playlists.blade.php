<html>
@include('components.head')
@include('components.nav')
<body>

<div class="container-fluid">
    <div class="playlistHeader pb-1">
        Choose a playlist that you follow or insert a link below to a playlist instead.
    </div>

    <div class="form-group playlistForm">
        <select class="form-control my-3" id="playlistSelect" onchange="window.location='http://134.122.70.206/playlist/' + this.value">
            <option disabled selected value> Select a playlist </option>
            @foreach($items as $item)
                <option class="option"  value="{{$item[1]}}">{{$item[0]}}</option>
            @endforeach
        </select>

        <input class="form-control" type="text" placeholder="Insert a link to a playlist here ..."> <a href="" class="btn btn-primary">Choose!</a>
    </div>

</div>

</body>
@include('components.footer')
</html>