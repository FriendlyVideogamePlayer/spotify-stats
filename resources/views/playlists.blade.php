<html>
@include('components.head')
@include('components.nav')
<body>

<div class="container-fluid">
    <div class="playlistHeader pt-3 pb-1">
        Choose a playlist that you follow
    </div>

    <div class="form-group playlistForm">
        <select class="form-control mt-3 mb-5" id="playlistSelect" onchange="window.location='http://134.122.70.206/playlist/' + this.value">
            <option disabled selected value> Select a playlist </option>
            @foreach($items as $item)
                <option class="option"  value="{{$item[1]}}">{{$item[0]}}</option>
            @endforeach
        </select>

        <div class="playlistHeader pt-2 pb-1">
        Alternatively insert a link below to a playlist instead.
        </div>
        
        <input class="form-control my-4" type="text" id="playlistURL" placeholder="e.g https://open.spotify.com/playlist/37i9dQZF1DXa8NOEUWPn9W"> 
        <div class="index"> <button onclick="playlistSelect();" class="btn btn-primary">Choose!</button></div>
    </div>

</div>
</body>
<script>
    function playlistSelect () {
        var URL = document.getElementById('playlistURL').value;
        if(URL.indexOf('open.spotify.com')) {
            var split = URL.split('/');
            var qSplit = split[4].split('?');
            var playlistId = qSplit[0];
            window.location='http://134.122.70.206/playlist/' + playlistId;
        }
    }
</script>
@include('components.footer')
</html>