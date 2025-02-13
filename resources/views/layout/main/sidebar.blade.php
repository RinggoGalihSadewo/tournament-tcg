<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
      <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
      <!-- nav bar -->
      <div class="w-100 mb-4 d-flex">
        <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ url('/admin/tcg') }}">
          <img src="{{ asset('assets/img/logo.png') }}" alt="" width="150px">
        </a>
      </div>
      <ul class="navbar-nav flex-fill w-100 mb-2">
        <li class="nav-item w-100">
          <a class="nav-link pl-3 {{ (request()->is('admin/tcg*')) ? 'active_sidebar' : '' }}" href="{{ url('/admin/tcg') }}">
            <i class="fe fe-file fe-16"></i><span class="ml-1">TCG</span></a>
        </li>
        <li class="nav-item w-100">
          <a class="nav-link pl-3 {{ (request()->segment(2) === 'tournament') ? 'active_sidebar' : '' }}" href="{{ url('/admin/tournament') }}">
              <i class="fe fe-layout fe-16"></i><span class="ml-1">Tournament</span>
          </a>
      </li>
      <li class="nav-item w-100">
          <a class="nav-link pl-3 {{ (request()->segment(2) === 'tournament-participants') ? 'active_sidebar' : '' }}" href="{{ url('/admin/tournament-participants') }}">
              <i class="fe fe-users fe-16"></i><span class="ml-1">Tournament Participants</span>
          </a>
      </li>
        <li class="nav-item w-100">
          <a class="nav-link pl-3 {{ (request()->is('admin/report*')) ? 'active_sidebar' : '' }}" href="{{ url('/admin/report') }}"><i class="fe fe-file-text fe-16"></i><span class="ml-1">Report</span></a>

        </li>
      </ul>
    </nav>  
</aside>