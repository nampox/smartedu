@extends('layouts.app')

@section('title', 'Giới thiệu - SmartEdu')

@section('content')
    <!-- Page Header -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Về SmartEdu</h1>
                    <p class="lead">
                        Hệ thống giáo dục thông minh kết nối học viên với những khóa học chất lượng cao
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Sứ mệnh của chúng tôi</h2>
                    <p class="lead text-muted mb-4">
                        SmartEdu được thành lập với sứ mệnh mang đến cơ hội học tập chất lượng cao 
                        cho mọi người, mọi nơi trên thế giới.
                    </p>
                    <p class="text-muted">
                        Chúng tôi tin rằng giáo dục là chìa khóa để mở ra những cơ hội mới và 
                        thay đổi cuộc sống. Với đội ngũ giảng viên chuyên nghiệp và công nghệ 
                        học tập tiên tiến, chúng tôi cam kết mang đến những trải nghiệm học tập 
                        tốt nhất cho học viên.
                    </p>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400/667eea/ffffff?text=Our+Mission" 
                         alt="Our Mission" class="img-fluid rounded">
                </div>
            </div>

            <div class="row align-items-center mb-5">
                <div class="col-lg-6 order-lg-2">
                    <h2 class="fw-bold mb-4">Tầm nhìn</h2>
                    <p class="lead text-muted mb-4">
                        Trở thành nền tảng giáo dục trực tuyến hàng đầu tại Việt Nam và khu vực Đông Nam Á.
                    </p>
                    <p class="text-muted">
                        Chúng tôi mong muốn xây dựng một cộng đồng học tập sôi động, nơi mọi người 
                        có thể chia sẻ kiến thức, kỹ năng và kinh nghiệm. SmartEdu sẽ là cầu nối 
                        giữa những người có nhu cầu học tập và những chuyên gia có kiến thức chuyên sâu.
                    </p>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <img src="https://via.placeholder.com/600x400/28a745/ffffff?text=Our+Vision" 
                         alt="Our Vision" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="display-5 fw-bold mb-3">Giá trị cốt lõi</h2>
                    <p class="lead text-muted">
                        Những nguyên tắc định hướng cho mọi hoạt động của chúng tôi
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="bi bi-lightbulb text-primary fs-1"></i>
                            </div>
                            <h5 class="card-title">Sáng tạo</h5>
                            <p class="card-text text-muted">
                                Luôn tìm kiếm những phương pháp giảng dạy mới và công nghệ tiên tiến 
                                để mang đến trải nghiệm học tập tốt nhất.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="bi bi-award text-success fs-1"></i>
                            </div>
                            <h5 class="card-title">Chất lượng</h5>
                            <p class="card-text text-muted">
                                Cam kết mang đến những khóa học chất lượng cao với nội dung 
                                được kiểm duyệt nghiêm ngặt.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="bi bi-people text-warning fs-1"></i>
                            </div>
                            <h5 class="card-title">Cộng đồng</h5>
                            <p class="card-text text-muted">
                                Xây dựng một cộng đồng học tập sôi động, nơi mọi người 
                                có thể hỗ trợ và chia sẻ kiến thức lẫn nhau.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 