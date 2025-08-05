@extends('layouts.app')

@section('title', 'Trang chủ - SmartEdu')

@section('content')
    <!-- Hero Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #EBF8FF 0%, #E0E7FF 100%);">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Content -->
                <div class="col-lg-6">
                    <div class="mb-5">
                        <!-- Free Banner -->
                        <div class="mb-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary border-0 px-3 py-2">
                                🎉 Miễn phí 7 ngày đầu tiên
                            </span>
                        </div>
                        
                        <!-- Main Headline -->
                        <h1 class="display-3 fw-bold mb-4 text-dark">
                            Học trực tuyến<span class="text-primary"> hiệu quả</span> với<span class="text-primary"> chuyên gia</span>
                        </h1>
                        
                        <!-- Description -->
                        <p class="lead mb-5 text-muted">
                            Nền tảng học trực tuyến hàng đầu với hơn 1000+ khóa học chất lượng cao, 
                            lớp học trực tiếp và cộng đồng học viên năng động.
                        </p>
                        
                        <!-- Statistics -->
                        <div class="d-flex flex-wrap gap-4 mb-5">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-people text-primary fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-5">50,000+</div>
                                    <div class="text-muted small">Học viên</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-book text-success fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-5">1,200+</div>
                                    <div class="text-muted small">Khóa học</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-star text-warning fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-5">4.8/5</div>
                                    <div class="text-muted small">Đánh giá</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Call to Action Buttons -->
                        <div class="d-flex flex-column flex-sm-row gap-3 mb-5">
                            <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg px-4">
                                Khám phá khóa học
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-lg px-4">
                                <i class="bi bi-play-circle me-2"></i>Xem demo
                            </a>
                        </div>
                        
                        <!-- Trusted Companies -->
                        <div class="pt-4 border-top">
                            <p class="text-muted small mb-3">Được tin tưởng bởi các công ty hàng đầu</p>
                            <div class="d-flex gap-4 opacity-60">
                                <div class="fw-bold text-muted">COMPANY A</div>
                                <div class="fw-bold text-muted">COMPANY B</div>
                                <div class="fw-bold text-muted">COMPANY C</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Dashboard Image -->
                <div class="col-lg-6">
                    <div class="position-relative">
                        <div class="bg-white rounded-3 shadow-lg overflow-hidden">
                            <img alt="EduPlatform Dashboard" class="w-100 h-auto" 
                                 src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/attachments/gen-images/public/online-learning-dashboard-CukB7fZSqRXbFysfoHUBwRTjdMOoGH.png">
                            
                            <!-- Live Indicator Overlay -->
                            <div class="position-absolute top-0 end-0 m-3">
                                <div class="bg-white rounded p-3 shadow">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success rounded-circle me-2 animate-pulse" style="width: 8px; height: 8px;"></div>
                                        <span class="small fw-medium">Live: 1,234 học viên</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Rating Overlay -->
                            <div class="position-absolute bottom-0 start-0 m-3">
                                <div class="bg-white rounded p-3 shadow">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-star-fill text-warning me-2"></i>
                                        <span class="small fw-medium">4.9 ★ (2,341 đánh giá)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Decorative Elements -->
                        <div class="position-absolute top-0 end-0 w-25 h-25 bg-primary bg-opacity-20 rounded-circle" style="z-index: -1;"></div>
                        <div class="position-absolute bottom-0 start-0 w-25 h-25 bg-info bg-opacity-20 rounded-circle" style="z-index: -1;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="display-5 fw-bold mb-3">Tại sao chọn SmartEdu?</h2>
                    <p class="lead text-muted">
                        Chúng tôi cung cấp những trải nghiệm học tập tốt nhất với công nghệ tiên tiến
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="bi bi-laptop text-primary fs-1"></i>
                            </div>
                            <h5 class="card-title">Học trực tuyến</h5>
                            <p class="card-text text-muted">
                                Học mọi lúc, mọi nơi với các khóa học trực tuyến chất lượng cao, 
                                tương tác trực tiếp với giảng viên.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="bi bi-person-workspace text-success fs-1"></i>
                            </div>
                            <h5 class="card-title">Giảng viên chuyên nghiệp</h5>
                            <p class="card-text text-muted">
                                Đội ngũ giảng viên giàu kinh nghiệm, chuyên môn cao từ các trường đại học 
                                và doanh nghiệp hàng đầu.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="bi bi-award text-warning fs-1"></i>
                            </div>
                            <h5 class="card-title">Chứng chỉ uy tín</h5>
                            <p class="card-text text-muted">
                                Nhận chứng chỉ được công nhận sau khi hoàn thành khóa học, 
                                tăng cơ hội nghề nghiệp.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Courses Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="display-5 fw-bold mb-3">Khóa học nổi bật</h2>
                    <p class="lead text-muted">
                        Khám phá những khóa học được yêu thích nhất từ cộng đồng học viên
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                @for ($i = 1; $i <= 6; $i++)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="https://via.placeholder.com/400x250/6c757d/ffffff?text=Course+{{ $i }}" 
                             class="card-img-top" alt="Course {{ $i }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary">Lập trình</span>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                    <small class="text-muted ms-1">(4.5)</small>
                                </div>
                            </div>
                            <h5 class="card-title">Khóa học {{ $i }}</h5>
                            <p class="card-text text-muted">
                                Mô tả ngắn về khóa học {{ $i }} và những gì học viên sẽ học được.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">2.500.000đ</span>
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-right"></i> Xem tất cả khóa học
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="p-4">
                        <i class="bi bi-people text-primary fs-1 mb-3"></i>
                        <h3 class="fw-bold">10,000+</h3>
                        <p class="text-muted">Học viên đã đăng ký</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="p-4">
                        <i class="bi bi-book text-success fs-1 mb-3"></i>
                        <h3 class="fw-bold">500+</h3>
                        <p class="text-muted">Khóa học chất lượng</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="p-4">
                        <i class="bi bi-person-workspace text-warning fs-1 mb-3"></i>
                        <h3 class="fw-bold">100+</h3>
                        <p class="text-muted">Giảng viên chuyên nghiệp</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="p-4">
                        <i class="bi bi-award text-info fs-1 mb-3"></i>
                        <h3 class="fw-bold">95%</h3>
                        <p class="text-muted">Học viên hài lòng</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 