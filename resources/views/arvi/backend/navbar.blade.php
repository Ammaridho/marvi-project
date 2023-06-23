<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl 
navbar-detached align-items-center bg-navbar-theme" id="layout-navbar" >
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <div class="small fw-normal">
            Last update time: 
            <span class="time-update">{{ $noww->format('d M Y H:i:s') }}</span>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" 
            href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
                <img src="/arvi/backend-assets/img/avatars/user-pp.png" 
                alt class="w-px-40 h-auto rounded-circle" />
            </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="javacsript:void(0)">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                        <img src="/arvi/backend-assets/img/avatars/user-pp.png" 
                        alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                    </div>
                    <div class="flex-grow-1">
                    <span class="fw-semibold d-block">{{$email}}</span>
                    <small class="text-muted">{{$access}}</small>
                    </div>
                </div>
                </a>
            </li>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <li>
                <a class="dropdown-item" href="{{route('choose-company')}}">
                    <i class="bx bx-repost me-2"></i>
                    <span class="align-middle">Switch Company</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="javascript:void(0)" 
                id="settingsAccount">
                    <i class="bx bx-cog me-2"></i>
                    <span class="align-middle">Settings</span>
                </a>
            </li>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <li>
                <form action="{{ secure_url(route('logout-dashboard')) }}" 
                method="post" name="logoutForm">
                    @csrf
                    <button class="dropdown-item" type="submit" 
                    onsubmit="return confirm('logout?')">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                    </button>
                </form>
            </li>
            </ul>
        </li>
        <!--/ User -->
        </ul>
    </div>
</nav>
<!-- / Navbar -->