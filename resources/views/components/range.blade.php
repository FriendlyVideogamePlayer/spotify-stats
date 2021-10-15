@if(isset($range))
    <ul class="nav adjusting-align mb-3">
        <li class="nav-item">
            <a @if($range == 'short_term') class="nav-link selectedNav" @else class="nav-link" @endif href="{{ route('top', ['type' => $type, 't' => 'short_term']) }}">4 Weeks</a>
        </li>
        <li class="nav-item">
            <a @if($range == 'medium_term') class="nav-link selectedNav" @else class="nav-link" @endif href="{{ route('top', ['type' => $type, 't' => 'medium_term']) }}">6 Months</a>
        </li>
        <li class="nav-item">
            <a @if($range == 'long_term') class="nav-link selectedNav" @else class="nav-link" @endif href="{{ route('top', ['type' => $type, 't' => 'long_term']) }}">All time</a>
        </li>
    </ul>
@else
    <div class="mb-3">
    </div>
@endif
