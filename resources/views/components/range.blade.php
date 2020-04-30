<ul class="nav justify-content-end mb-3">
    <li class="nav-item">
        <a @if($range == 'short_term') class="nav-link selectedNav" @else class="nav-link" @endif href="http://localhost/spotifystats/public/top{{$type}}?t=short_term">4 Weeks</a>
    </li>
    <li class="nav-item">
        <a @if($range == 'medium_term') class="nav-link selectedNav" @else class="nav-link" @endif href="http://localhost/spotifystats/public/top{{$type}}?t=medium_term">6 Months</a>
    </li>
    <li class="nav-item">
        <a @if($range == 'long_term') class="nav-link selectedNav" @else class="nav-link" @endif href="http://localhost/spotifystats/public/top{{$type}}?t=long_term">All time</a>
    </li>
</ul>