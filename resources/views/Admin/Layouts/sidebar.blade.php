<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
  <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html " target="_blank">
        {{-- <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo"> --}}
        <img src="../images/logo.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-2 font-weight-bold" style="font-size: 16pt"><b>SIMPI</b></span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}" href="{{ route('admin.dashboard.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-air-baloon"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.keuangan.index') ? 'active' : '' }}" href="{{ route('admin.keuangan.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-money-coins"></i>
            </div>
            <span class="nav-link-text ms-1">Manajemen Keuangan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('admin/sewaPemancingan*') ? 'active' : '' }}" href="/admin/sewaPemancingan">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-map-big"></i>
            </div>
            <span class="nav-link-text ms-1">Sewa Pemancingan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('admin/alatPancing*') ? 'active' : '' }}" href="/admin/alatPancing">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-box-2"></i>
            </div>
            <span class="nav-link-text ms-1">Daftar Alat Pancing</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('admin/sewaAlat*') ? 'active' : '' }}" href="/admin/sewaAlat">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-bullet-list-67"></i>
            </div>
            <span class="nav-link-text ms-1">Sewa Alat Pancing</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.pengelolaanIkan.index') ? 'active' : '' }}" href="{{ route('admin.pengelolaanIkan.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-app"></i>
            </div>
            <span class="nav-link-text ms-1">Pengelolaan Ikan</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/members*') ? 'active' : '' }}" href="/admin/members">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-badge"></i>
              </div>
              <span class="nav-link-text ms-1">Manajemen Member</span>
            </a>
        </li>
        <li class="nav-item">
           <a class="nav-link {{ request()->is('admin/blog*') ? 'active' : '' }}" href="/admin/blog">
             <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
               <i class="ni ni-archive-2"></i>
             </div>
             <span class="nav-link-text ms-1">Blog Pemancingan</span>
           </a>
         </li>
        {{-- <li class="nav-item">
           <a class="nav-link  " href="#">
             <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
               <i class="ni ni-chat-round"></i>
             </div>
             <span class="nav-link-text ms-1">Pesan</span>
           </a>
        </li> --}}
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-circle-08"></i>
              </div>
              <span class="nav-link-text ms-1">Logout</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </li>      
        <li class="nav-item">
          <a class="nav-link" href="{{ route('password.change') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-dark text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-key-25"></i>
              </div>
              <span class="nav-link-text ms-1">Change Password</span>
          </a>
        </li>      
      </ul>
    </div>
</aside>