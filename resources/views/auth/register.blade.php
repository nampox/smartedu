@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - SmartEdu')

@section('content')
    <!-- Hero Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #EBF8FF 0%, #E0E7FF 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="text-center mb-5">
                        <h1 class="display-4 fw-bold mb-3 text-dark">
                            Đăng ký tài khoản <span class="text-primary">SmartEdu</span>
                        </h1>
                        <p class="lead text-muted">
                            Tham gia cộng đồng học tập trực tuyến hàng đầu với hơn 50,000+ học viên
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <!-- Free Trial Banner -->
                            <div class="text-center mb-4">
                                <div class="bg-primary bg-opacity-10 rounded-pill px-4 py-2 d-inline-block">
                                    <i class="bi bi-gift text-primary me-2"></i>
                                    <span class="text-primary fw-semibold">Miễn phí 7 ngày đầu tiên</span>
                                </div>
                            </div>
                            
                            <!-- Registration Form -->
                            <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                                @csrf
                                
                                <!-- Name Field -->
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-person text-primary me-2"></i>Họ và tên
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="Nhập họ và tên của bạn"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
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
                                
                                <!-- Phone Field -->
                                <div class="mb-4">
                                    <label for="phone" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-telephone text-primary me-2"></i>Số điện thoại
                                    </label>
                                    <input type="tel" 
                                           class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}" 
                                           placeholder="0123456789"
                                           required>
                                    @error('phone')
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
                                               placeholder="Tối thiểu 8 ký tự"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Confirm Password Field -->
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-lock-fill text-primary me-2"></i>Xác nhận mật khẩu
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control form-control-lg" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               placeholder="Nhập lại mật khẩu"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Terms and Conditions -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label text-muted" for="terms">
                                            Tôi đồng ý với <a href="#" class="text-primary text-decoration-none">Điều khoản sử dụng</a> 
                                            và <a href="#" class="text-primary text-decoration-none">Chính sách bảo mật</a>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-person-plus me-2"></i>Đăng ký tài khoản
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
                                
                                <!-- Login Link -->
                                <div class="text-center">
                                    <p class="text-muted mb-0">
                                        Đã có tài khoản? 
                                        <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">
                                            Đăng nhập ngay
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Benefits Section -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h3 class="fw-bold mb-4">Lợi ích khi đăng ký</h3>
                        <div class="row g-4">
                            <div class="col-lg-3 col-md-6">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="bi bi-play-circle text-primary fs-4"></i>
                                    </div>
                                    <div class="text-start">
                                        <h6 class="fw-semibold mb-1">1000+ khóa học</h6>
                                        <small class="text-muted">Chất lượng cao</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
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
                            <div class="col-lg-3 col-md-6">
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
                            <div class="col-lg-3 col-md-6">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="bi bi-headset text-info fs-4"></i>
                                    </div>
                                    <div class="text-start">
                                        <h6 class="fw-semibold mb-1">Hỗ trợ 24/7</h6>
                                        <small class="text-muted">Tư vấn miễn phí</small>
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
    
    // Toggle confirm password visibility
    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const password = document.getElementById('password_confirmation');
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