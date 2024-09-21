<ul class="navbar-nav ml-auto">

    @if (Auth::check())
        <li class="nav-item {{ Route::is('home') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <a class="nav-link" href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
        </li>

    @else
        <li class="nav-item {{ Route::is('login') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
        <li class="nav-item {{ Route::is('register') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('register') }}">Registration</a>
        </li>
    @endif

</ul>

