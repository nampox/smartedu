<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div class="bg-primary rounded me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-mortarboard-fill text-white"></i>
            </div>
            <span class="fw-bold text-dark">EduPlatform</span>
        </a>
        
        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
                        Khóa học
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">
                        Lớp học trực tiếp
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->routeIs('teachers.*') ? 'active' : '' }}" href="{{ route('teachers.index') }}">
                        Giảng viên
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        Giới thiệu
                    </a>
                </li>
            </ul>
            
            <!-- Right Side Menu -->
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="">
                                <i class="bi bi-person"></i> Hồ sơ
                            </a></li>
                            <li><a class="dropdown-item" href="">
                                <i class="bi bi-speedometer2"></i> Bảng điều khiển
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Đăng xuất
                            </a></li>
                        </ul>
                    </li>
                    <form id="logout-form" action="" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="">
                            Đăng nhập
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-dark ms-2" href="">
                            Đăng ký
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav> 