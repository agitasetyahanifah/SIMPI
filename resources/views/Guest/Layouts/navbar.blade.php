<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <img src="{{ asset('images/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo" style="width: 35px">
      <a class="navbar-brand ms-2" href="{{ route('guest.landingpage.index') }}" style="font-size: 18pt"><b>SIMPI</b></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fa fa-bars p-1"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link  {{ request()->routeIs('guest.landingpage.index') ? 'active' : '' }}" aria-current="page" href="{{ route('guest.landingpage.index') }}">Home</a>
          <a class="nav-link  {{ request()->routeIs('guest.galeri.index') ? 'active' : '' }}" aria-current="page" href="{{ route('guest.galeri.index') }}">Galeri</a>
          <a class="nav-link  {{ request()->routeIs('guest.blog.index') ? 'active' : '' }}" aria-current="page" href="{{ route('guest.blog.index') }}">Blog</a>
          <a class="nav-link  {{ request()->routeIs('guest.spots.index') ? 'active' : '' }}" aria-current="page" href="{{ route('guest.spots.index') }}">Sewa Spot Pemancingan</a>
          <a class="nav-link  {{ request()->routeIs('guest.daftar-alat.index') ? 'active' : '' }}" aria-current="page" href="{{ route('guest.daftar-alat.index') }}">Sewa Alat Pancing</a>
        </div>
        <ul class="navbar-nav ms-lg-auto">
          @guest
              <li class="nav-item" style="padding: 0px 4px;">
                  <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-user"></i> Login</a>
              </li>
              <li class="nav-item" style="padding: 0px 4px;">
                  <a class="nav-link" href="{{ route('register') }}"><i class="fa fa-user"></i> Register</a>
              </li>
          @endguest
        </ul>      
        </div>
       </div>
    </div>
</nav>
<!-- End Navbar -->