<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
      <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
      <!-- nav bar -->
      <div class="w-100 mb-4 d-flex">
        <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ url('/data-peserta') }}">
          <img src="{{ asset('assets/img/logo.png') }}" alt="" width="150px">
        </a>
      </div>
      <ul class="navbar-nav flex-fill w-100 mb-2">
        <li class="nav-item dropdown">
          <a href="#profile" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link {{ (request()->is('data*')) ? 'active_sidebar' : '' }}">
            <i class="fe fe-user fe-16"></i>
            <span class="ml-3 item-text">Manajemen Data</span>
          </a>
          <ul class="collapse list-unstyled pl-4 w-100 mt-2" id="profile">
            <a class="nav-link pl-3 {{ (request()->is('data-peserta*')) ? 'active_sidebar' : '' }}" href="{{ url('/data-peserta') }}"><span class="ml-1">Data Peserta</span></a>
            <a class="nav-link pl-3 {{ (request()->is('data-admin*')) ? 'active_sidebar' : '' }}" href="{{ url('/data-admin') }}"><span class="ml-1">Data Admin</span></a>
          </ul>
        </li>
      </ul>
    </nav>
</aside>