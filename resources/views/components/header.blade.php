<header class="main-header">
    <!-- Logo -->
    <a href="/dashboard" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>GFC</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Global<b> FS</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                @if (Auth::check())
                    <li class="dropdown user user-menu">
                        <a href="/users/{{ Auth::user()->id }}/edit">{{ Auth::user()->name }}</a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();
                                    return confirm('Are you sure you want to logout?');">&nbsp;<i class="fa fa-power-off"></i>&nbsp;</a>
                </li>
            </ul>
        </div>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</header>
