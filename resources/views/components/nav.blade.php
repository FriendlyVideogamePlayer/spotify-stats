<nav class="navbar navbar-expand-md navbar-dark mb-1">
  <a class="plainItem navbar-brand" >Spotify stats</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('toptracks') ? 'selectedNav' : '' }}" href="http://134.122.70.206/toptracks">Top Tracks</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('topartists') ? 'selectedNav' : '' }}" href="http://134.122.70.206/topartists">Top Artists</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('recommendations') ? 'selectedNav' : '' }}" href="http://134.122.70.206/recommendations">Reccommendations</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('playlists') ? 'selectedNav' : '' }}" href="http://134.122.70.206/playlists">Playlists</a>
      </li>
    </ul>
  </div>
  <div class="collapse navbar-collapse justify-content-end" id="navbarRight">
  <ul class="navbar-nav">
    <li class="nav-item">
      <p class="plainItem nav-link"><?php echo session('username'); ?></p>
    </li>
    <li class="nav-item">
      <img class="userImage" src="{{ session('userImage') ?? asset('images/noimage.png') }}" alt="userImage">
    </li>
  </ul>
</div>

  </div>
</nav>