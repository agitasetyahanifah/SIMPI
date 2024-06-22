<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <img src="{{ asset('images/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo" style="width: 35px">
      <a class="navbar-brand ms-2" href="{{ route('member.landingpage.index') }}" style="font-size: 18pt"><b>SIMPI</b></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fa fa-bars p-1"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link  {{ request()->routeIs('member.landingpage.index') ? 'active' : '' }}" aria-current="page" href="{{ route('member.landingpage.index') }}">Home</a>
          <a class="nav-link  {{ request()->routeIs('member.galeri.index') ? 'active' : '' }}" aria-current="page" href="{{ route('member.galeri.index') }}">Gallery</a>
          <a class="nav-link  {{ request()->routeIs('member.blog.index') ? 'active' : '' }}" aria-current="page" href="{{ route('member.blog.index') }}">Blogs</a>
          <a class="nav-link  {{ request()->routeIs('member.spots.index') ? 'active' : '' }}" aria-current="page" href="{{ route('member.spots.index') }}">Fishing Spot Rental</a>
          <a class="nav-link  {{ request()->routeIs('member.daftar-alat.index') ? 'active' : '' }}" aria-current="page" href="{{ route('member.daftar-alat.index') }}">Fishing Equipment Rental</a>
        </div>
        <ul class="navbar-nav ms-lg-auto">
          <li class="nav-item dropdown" style="padding: 0px 4px;">
              @if(Auth::check())
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      {{ Auth::user()->nama }} <i class="fa fa-user ms-2"></i>
                  </a>
              @endif
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="{{ route('password.change') }}">Ubah Password</a></li>
                  {{-- <li><a class="dropdown-item" href="#">Settings</a></li> --}}
                  <li><hr class="dropdown-divider"></li>
                  <li>
                      <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <button type="submit" class="dropdown-item">Logout</button>
                      </form>
                  </li>
              </ul>
          </li>
        </ul>
        </div>
       </div>
    </div>
</nav>
<!-- End Navbar -->

<!-- Make sure to include Bootstrap JS for the dropdown functionality -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGz6YFujI6pGwt6rK/xFt02UANUqNQF8RWvwLI8pL8/k/" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha384-wEmeIV1mKuiNpM0mQXvPH1rZjG7eRh5ykM1jDD2ylEzTjoK2P5d6MGzGZn8p2aU7" crossorigin="anonymous"></script>