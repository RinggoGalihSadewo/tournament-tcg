    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- Navbar Area -->
        <div class="oneMusic-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="oneMusicNav">

                        <!-- Nav brand -->
                        <a href="/" class="nav-brand"><img src="{{ asset('assets/img/logo.png') }}" alt=""></a>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="/">Home</a></li>
                                    <li><a href="/tournaments">Tournaments</a></li>
                                    @if(session()->has('user'))
                                    <li><a href="/my-events">My Events</a></li>
                                    <li><a href="/deck-log">Deck Log</a></li>
                                    <li><a href="#">{{ Auth::user()->name }}</a>
                                        <ul class="dropdown">
                                            <li><a href="/my-profile">My Profile</a></li>
                                            <li><a id="btnLogout" style="cursor: pointer;">Logout</a></li>
                                        </ul>
                                    </li>
                                    @endif
                                </ul>

                                {{-- @if(Auth::user()->name) --}}
                                <!-- Login/Register & Cart Button -->
                                <div class="login-register-cart-button d-flex align-items-center">
                                    <!-- Login/Register -->
                                    <div class="login-register-btn mr-50">
                                        @if(!session()->has('user'))
                                        <a href="/login" id="loginBtn">Login / Register</a>
                                        @endif
                                    </div>
                                </div>
                                {{-- @endif --}}
                            </div>
                            <!-- Nav End -->

                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->