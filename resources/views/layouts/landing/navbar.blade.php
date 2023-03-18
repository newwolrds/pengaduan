<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="/">Pengaduan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
            @if(request()->is('login*') || request()->is('register*') || request()->is('my-complaint*'))
            <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
            @else
            <li class="nav-item"><a class="nav-link" href="#services">Alur Pengaduan</a></li>
            <li class="nav-item"><a class="nav-link" href="#portfolio">Pengaduan Terbaru</a></li>
            @endif
            @guest
                @if(request()->is('login*') || request()->is('register*') || request()->is('my-complaint*'))
                @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Buat Pengaduan</a></li>
                @endif
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Daftar</a></li>
            @else
            @if(request()->is('login*') || request()->is('register*') || request()->is('my-complaint*'))
                @else
                <li class="nav-item"><a class="nav-link" href="#contact">Buat Pengaduan</a></li>
                @endif
                @if(auth()->user()->role == 'admin')
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin_dashboard.index') }}">Dashboard</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('landing.my_complaint.index') }}">Pengaduan Saya</a></li>
                @endif
                <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            @endguest
            </ul>
        </div>
    </div>
</nav>