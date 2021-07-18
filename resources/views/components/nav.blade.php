<nav class="navbar navbar-expand-md navbar-dark navbar-underline mb-1">
  <a class="plainItem navbar-brand" >Spotify stats</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse navbar-adjust-size" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('toptracks') ? 'selectedNav' : '' }}" href="{{ route('top', ['type' => 'tracks']) }}">Top Tracks</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('topartists') ? 'selectedNav' : '' }}" href="{{ route('top', ['type' => 'artists']) }}">Top Artists</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('recommendations') ? 'selectedNav' : '' }}" href="{{ route('recommendations') }}">Recommendations</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('playlists') ? 'selectedNav' : '' }}" href="{{ route('playlists') }}">Playlists</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('morelikethis') ? 'selectedNav' : '' }}" href="{{ route('morelikethis') }}">More like this</a>
      </li>
    </ul>
  </div>
  <div class="collapse navbar-collapse justify-content-end" id="navbarRight">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="plainItem nav-link"><?php echo session('username'); ?></a>
    </li>
    <li class="nav-item">
      <img class="userImage" src="{{ session('userImage') ?? asset('images/noimage.png') }}" alt="userImage">
    </li>
  </ul>
</div>

  </div>
</nav>