@extends('layouts.app')

@section('title', 'Liên hệ - SmartEdu')

@section('content')
    <!-- Page Header -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Liên hệ với chúng tôi</h1>
                    <p class="lead">
                        Chúng tôi luôn sẵn sàng hỗ trợ và giải đáp mọi thắc mắc của bạn
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Contact Form -->
                <div class="col-lg-8 mb-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <h3 class="mb-4">Gửi tin nhắn cho chúng tôi</h3>
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">Họ và tên *</label>
                                        <input type="text" class="form-control" id="firstName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Tiêu đề *</label>
                                    <input type="text" class="form-control" id="subject" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Nội dung tin nhắn *</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Gửi tin nhắn
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">
                                <i class="bi bi-geo-alt text-primary"></i> Địa chỉ
                            </h5>
                            <p class="card-text text-muted">
                                123 Đường ABC, Quận 1<br>
                                TP.Hồ Chí Minh, Việt Nam
                            </p>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">
                                <i class="bi bi-telephone text-primary"></i> Điện thoại
                            </h5>
                            <p class="card-text text-muted">
                                <strong>Hotline:</strong> +84 123 456 789<br>
                                <strong>Hỗ trợ:</strong> +84 987 654 321
                            </p>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">
                                <i class="bi bi-envelope text-primary"></i> Email
                            </h5>
                            <p class="card-text text-muted">
                                <strong>Thông tin:</strong> info@smartedu.vn<br>
                                <strong>Hỗ trợ:</strong> support@smartedu.vn
                            </p>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">
                                <i class="bi bi-clock text-primary"></i> Giờ làm việc
                            </h5>
                            <p class="card-text text-muted">
                                <strong>Thứ 2 - Thứ 6:</strong> 8:00 - 18:00<br>
                                <strong>Thứ 7:</strong> 8:00 - 12:00<br>
                                <strong>Chủ nhật:</strong> Nghỉ
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center mb-4">Vị trí của chúng tôi</h3>
                    <div class="ratio ratio-21x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.424177981303!2d106.6983153148008!3d10.776008992319!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f46f64b933f%3A0xf8a6e5b2a5a4f1f4!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgVGjDtG5nIHRpbiB2aWV0!5e0!3m2!1svi!2s!4v1629789456789!5m2!1svi!2s" 
                                style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h3 class="text-center mb-5">Câu hỏi thường gặp</h3>
                    
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Làm thế nào để đăng ký khóa học?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bạn có thể đăng ký khóa học bằng cách tạo tài khoản, chọn khóa học mong muốn 
                                    và thực hiện thanh toán theo hướng dẫn.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Tôi có thể học offline không?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Hiện tại chúng tôi chỉ cung cấp các khóa học trực tuyến. Tuy nhiên, 
                                    chúng tôi đang lên kế hoạch mở các lớp học offline trong tương lai.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Chứng chỉ có được công nhận không?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Chứng chỉ của chúng tôi được công nhận bởi nhiều doanh nghiệp và tổ chức 
                                    giáo dục. Tuy nhiên, mức độ công nhận có thể khác nhau tùy theo ngành nghề.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 