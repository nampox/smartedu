@extends('layouts.app')

@section('title', 'Giảng viên - SmartEdu')

@section('content')
    <!-- Page Header -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Đội ngũ giảng viên</h1>
                    <p class="lead">
                        Gặp gỡ những chuyên gia hàng đầu với kinh nghiệm giảng dạy phong phú
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Teachers Grid -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @for ($i = 1; $i <= 8; $i++)
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <img src="https://via.placeholder.com/150x150/6c757d/ffffff?text=Teacher+{{ $i }}" 
                                 class="rounded-circle mb-3" style="width: 120px; height: 120px;" alt="Teacher {{ $i }}">
                            <h5 class="card-title">Giảng viên {{ $i }}</h5>
                            <p class="text-muted mb-2">Chuyên gia Lập trình</p>
                            <div class="text-warning mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <small class="text-muted ms-1">(4.8)</small>
                            </div>
                            <p class="card-text text-muted small">
                                {{ $i * 5 }} khóa học • {{ $i * 100 }} học viên
                            </p>
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> Xem hồ sơ
                            </a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="p-4">
                        <i class="bi bi-person-workspace text-primary fs-1 mb-3"></i>
                        <h3 class="fw-bold">100+</h3>
                        <p class="text-muted">Giảng viên chuyên nghiệp</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="p-4">
                        <i class="bi bi-award text-success fs-1 mb-3"></i>
                        <h3 class="fw-bold">15+</h3>
                        <p class="text-muted">Năm kinh nghiệm trung bình</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="p-4">
                        <i class="bi bi-mortarboard text-warning fs-1 mb-3"></i>
                        <h3 class="fw-bold">50+</h3>
                        <p class="text-muted">Trường đại học đối tác</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="p-4">
                        <i class="bi bi-people text-info fs-1 mb-3"></i>
                        <h3 class="fw-bold">10,000+</h3>
                        <p class="text-muted">Học viên đã đào tạo</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 