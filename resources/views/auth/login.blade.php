@extends('layouts.app')

@section('title', 'Đăng nhập - SmartEdu')

@section('content')
    <!-- Hero Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #EBF8FF 0%, #E0E7FF 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="text-center mb-5">
                        <h1 class="display-4 fw-bold mb-3 text-dark">
                            Đăng nhập <span class="text-primary">SmartEdu</span>
                        </h1>
                        <p class="lead text-muted">
                            Chào mừng bạn quay trở lại! Đăng nhập để tiếp tục học tập
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <!-- Welcome Back Banner -->
                            <div class="text-center mb-4">
                                <div class="bg-primary bg-opacity-10 rounded-pill px-4 py-2 d-inline-block">
                                    <i class="bi bi-person-check text-primary me-2"></i>
                                    <span class="text-primary fw-semibold">Chào mừng trở lại!</span>
                                </div>
                            </div>
                            
                            <!-- Login Form -->
                            <form method="POST" action="{{ route('login.post') }}" class="needs-validation" novalidate>
                                @csrf
                                
                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-envelope text-primary me-2"></i>Email
                                    </label>
                                    <input type="email" 
                                           class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="example@email.com"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Password Field -->
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-lock text-primary me-2"></i>Mật khẩu
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Nhập mật khẩu của bạn"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Remember Me & Forgot Password -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                        <label class="form-check-label text-muted" for="remember">
                                            Ghi nhớ đăng nhập
                                        </label>
                                    </div>
                                    <a href="#" class="text-primary text-decoration-none small">
                                        Quên mật khẩu?
                                    </a>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
                                    </button>
                                </div>
                                
                                <!-- Divider -->
                                <div class="text-center mb-4">
                                    <span class="text-muted">hoặc</span>
                                </div>
                                
                                <!-- Social Login Buttons -->
                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-dark btn-lg w-100">
                                            <i class="bi bi-google me-2"></i>Google
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-primary btn-lg w-100">
                                            <i class="bi bi-facebook me-2"></i>Facebook
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Register Link -->
                                <div class="text-center">
                                    <p class="text-muted mb-0">
                                        Chưa có tài khoản? 
                                        <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">
                                            Đăng ký ngay
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Features Section -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h3 class="fw-bold mb-4">Tại sao chọn SmartEdu?</h3>
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="bi bi-play-circle text-primary fs-4"></i>
                                    </div>
                                    <div class="text-start">
                                        <h6 class="fw-semibold mb-1">Học mọi lúc</h6>
                                        <small class="text-muted">24/7 truy cập</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="bi bi-award text-success fs-4"></i>
                                    </div>
                                    <div class="text-start">
                                        <h6 class="fw-semibold mb-1">Chứng chỉ</h6>
                                        <small class="text-muted">Được công nhận</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="bi bi-people text-warning fs-4"></i>
                                    </div>
                                    <div class="text-start">
                                        <h6 class="fw-semibold mb-1">Cộng đồng</h6>
                                        <small class="text-muted">50,000+ học viên</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
    
    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endpush 