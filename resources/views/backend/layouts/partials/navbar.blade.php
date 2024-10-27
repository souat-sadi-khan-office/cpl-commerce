<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> 
                    <i class="bi bi-list"></i> 
                </a>
            </li>
            <li class="nav-item d-none d-md-block"> 
                <a href="{{ route('home') }}" target="_blank" class="nav-link btn btn-icon btn-circle btn-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Website">
                    <i class="bi bi-globe-americas"></i>
                </a> 
            </li>
            
            <li class="nav-item d-none d-md-block"> 
                <a href="javascript:;" class="btn btn-soft-danger" id="clearCache" data-url="{{ route('admin.clear.cache') }}">
                    <i class="bi bi-stars"></i>
                    Optimize 
                </a> 
            </li>
            <li class="nav-item d-none d-md-block"> 
                <a href="javascript:;" class="nav-link">
                    {{ get_system_date(date('Y-m-d H:i:s')) }}
                    {{ get_system_time(date('Y-m-d H:i:s')) }}
                </a> 
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">
            
            <!-- Fullscreen Toggle -->
            <li class="nav-item"> 
                <a class="nav-link" href="javascript:;" data-lte-toggle="fullscreen"> 
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> 
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> 
                </a> 
            </li>
            
            <!-- Mode Toggle -->
            <li class="nav-item dropdown">
                <button class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
                    <span class="theme-icon-active">
                        <i class="my-1"></i>
                    </span>
                    <span class="d-lg-none ms-2" id="bd-theme-text">Toggle theme</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme-text"
                    style="--bs-dropdown-min-width: 8rem;">
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light" aria-pressed="false">
                            <i class="bi bi-sun-fill me-2"></i>
                            Light
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                            <i class="bi bi-moon-fill me-2"></i>
                            Dark
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" aria-pressed="true">
                            <i class="bi bi-circle-half me-2"></i>
                            Auto
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>
                </ul>
            </li>

            <!-- User Menu Dropdown -->
            <li class="nav-item dropdown user-menu"> 
                <a href="javascript:;" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> 
                    <img
                        src="{{ asset('pictures/face.jpg') }}"
                        class="user-image rounded-circle shadow" 
                        alt="User Image"> 
                    <span class="d-none d-md-inline">{{ Auth::guard('admin')->user()->name }}</span> 
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-app-color"> 
                        <img src="{{ asset('pictures/face.jpg') }}" class="rounded-circle shadow" alt="User Image">
                        <p>
                            {{ Auth::guard('admin')->user()->name }} - {{ Auth::guard('admin')->user()->designation }}
                            <small>Member since Nov. 2023</small>
                        </p>
                    </li>
                    <li class="user-footer"> 
                        <a href="javascript:;" class="btn btn-soft-warning btn-flat">Profile</a> 
                        <a href="javascript:;" data-url="{{ route('admin.logout') }}" id="logout" class="btn btn-soft-danger btn-flat float-end">Sign out</a> 
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>