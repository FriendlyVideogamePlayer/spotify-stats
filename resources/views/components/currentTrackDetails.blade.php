<div class="header pb-1" role="heading" aria-level="1">
    You are currently listening to ...
</div>
@if($type == "currentTrack")
<div class="currentTrackDetails pb-3">
    <img class="currentImage" src="{{$currentTrackInfo['album']['images']['1']['url']}}" alt="Album art for - {{$currentTrackInfo['name']}}" style="object-fit: cover;">
    {{$currentTrackInfo['name']}} by {{$currentTrackInfo['artists']['0']['name']}}
</div>
<div class="currentTrackDetails pb-3">
    Below are some more songs that you might like!
</div>
@elseif($type == "204-unavailable")
<div class="currentTrackDetails pb-3">
    Nothing ...
</div>
<div class="currentTrackDetails pb-3">
    It looks like you arent listening to a song on Spotify. Try disabling offline mode or starting a song.
</div>
@endif