<html>
@include('components.head')
@include('components.nav')
<body>

<div class="container-fluid">
    <div class="playlistHeader pb-1">
        Statistics for your playlist "{{$title}}"
    </div>

    <div> Most Danceable   {{$trackArray['danceabilityTrack']}} </div>
    <div> Most Energetic   {{$trackArray['energyTrack']}} </div> 
    <div> Loudest Song     {{$trackArray['loudnessTrack']}} </div> 
    <div> Highest Tempo    {{$trackArray['tempoTrack']}} </div> 
	<div> Highest Valence  {{$trackArray['valenceTrack']}} </div> 
	<div> Longest Song Length  {{$trackArray['durationTrack']}} </div> 

</div>

</body>
@include('components.footer')
</html>