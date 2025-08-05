<footer class="footer py-5 mt-5">
    <div class="container">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="mb-3">
                    <i class="bi bi-mortarboard-fill text-primary"></i>
                    SmartEdu
                </h5>
                <p class="text-muted">
                    Hệ thống giáo dục thông minh, kết nối học viên với những khóa học chất lượng cao 
                    và giảng viên chuyên nghiệp.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-muted"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="text-muted"><i class="bi bi-twitter fs-5"></i></a>
                    <a href="#" class="text-muted"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-muted"><i class="bi bi-linkedin fs-5"></i></a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="mb-3">Liên kết nhanh</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> Trang chủ
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('courses.index') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> Khóa học
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('teachers.index') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> Giảng viên
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('about') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> Giới thiệu
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Support -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="mb-3">Hỗ trợ</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('contact') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> Liên hệ
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> FAQ
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> Hướng dẫn
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-muted text-decoration-none">
                            <i class="bi bi-chevron-right"></i> Chính sách
                        </a>
                    </li>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h6 class="mb-3">Thông tin liên hệ</h6>
                <div class="d-flex mb-2">
                    <i class="bi bi-geo-alt text-primary me-2"></i>
                    <span class="text-muted">123 Đường ABC, Quận 1, TP.HCM</span>
                </div>
                <div class="d-flex mb-2">
                    <i class="bi bi-telephone text-primary me-2"></i>
                    <span class="text-muted">+84 123 456 789</span>
                </div>
                <div class="d-flex mb-2">
                    <i class="bi bi-envelope text-primary me-2"></i>
                    <span class="text-muted">info@smartedu.vn</span>
                </div>
                <div class="d-flex">
                    <i class="bi bi-clock text-primary me-2"></i>
                    <span class="text-muted">Thứ 2 - Thứ 6: 8:00 - 18:00</span>
                </div>
            </div>
        </div>
        
        <hr class="my-4">
        
        <!-- Bottom Footer -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    © {{ date('Y') }} SmartEdu. Tất cả quyền được bảo lưu.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-muted mb-0">
                    Được phát triển với <i class="bi bi-heart-fill text-danger"></i> tại Việt Nam
                </p>
            </div>
        </div>
    </div>
</footer> 