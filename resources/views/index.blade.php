<html lang="en">
@include('components.head')
<body>
<div class="homeFooter" role="main">
    <div class="container justify-content-center">
        <div class="header pb-5 pt-5" role="heading" aria-level="1">
            Spotify stats
        </div>
        <div class="index">
            <p class="lead text-card pb-3">This site will allow you to see your top 50 tracks and artists on Spotify, as well as see recommendations for songs you might like.</p>
            <a href="http://134.122.70.206/authorize" class="btn btn-primary my-3">Connect your Spotify!</a>
            </p>
        </div>
    </div>

    <div class="album pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="card mb-4 box-shadow card-home">
                        <img class="card-img-top cardPurple" alt="example image of the top tracks page" style="height: auto; width: 100%; display: block;" src="{{asset('images/toptracks.png')}}">
                        <div class="card-body">
                            <p class="card-text lead text-card">View your top 50 tracks/artists on Spotify from the last 4 weeks, 6 months or all time!</p>
                            <div class="d-flex justify-content-between align-items-center">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="card mb-4 box-shadow card-home">
                        <img class="card-img-top cardPurple" alt="example image of the recommendations page" style="height: auto; width: 100%; display: block;" src="{{asset('images/recommendations.png')}}" >
                        <div class="card-body">
                            <p class="card-text lead text-card">View 50 recommended tracks based upon your top tracks and artists.</p>
                            <div class="d-flex justify-content-between align-items-center">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="card mb-4 box-shadow card-home">
                        <img class="card-img-top cardPurple" alt="example image of the playlist statistics page" style="height: auto; width: 100%; display: block;" src="{{asset('images/playlists.png')}}" >
                        <div class="card-body">
                            <p class="card-text lead text-card">View statistics about your favourite playlists.</p>
                            <div class="d-flex justify-content-between align-items-center">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
@include('components.footer')
</html>