<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="{{ route('home') }}" class="logo"><img src="{{ asset('assets/images/habari_Logo.png') }}"
                            style="width: 60px; height: 40px;"> Recruitment<em> Portal</em></a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="{{ route('home') }}" >Home</a></li>
                        <li><a href="{{ route('jobs.index') }}">Jobs</a></li>

                        {{-- <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown"  role="button"
                                aria-haspopup="true" aria-expanded="false">About</a>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('announcements.index') }}">Announcements</a>
                                <a class="dropdown-item" href="{{ route('news.index') }}">News</a>
                                <a class="dropdown-item" href="#">Contact Us</a>
                            </div>
                        </li> --}}
                        @if (Route::has('login'))
                            @auth
                                <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            @else
                                <li><a href="{{ route('login') }}">Login</a></li>

                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
