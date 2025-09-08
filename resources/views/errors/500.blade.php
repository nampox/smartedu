@extends('layouts.app')

@section('title', '500 - Lỗi máy chủ')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="py-5">
                <!-- 500 Icon -->
                <div class="mb-4">
                    <i class="bi bi-gear-fill text-danger" style="font-size: 5rem;"></i>
                </div>
                
                <!-- Error Message -->
                <h1 class="display-1 fw-bold text-danger">500</h1>
                <h2 class="h3 mb-3">Lỗi máy chủ</h2>
                <p class="lead text-muted mb-4">
                    Đã xảy ra lỗi trong quá trình xử lý yêu cầu của bạn. 
                    Chúng tôi đang khắc phục sự cố này.
                </p>
                
                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="bi bi-house"></i> Về trang chủ
                    </a>
                    <button onclick="location.reload()" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise"></i> Thử lại
                    </button>
                </div>
                
                <!-- Help Text -->
                <div class="mt-5">
                    <p class="text-muted small">
                        Nếu lỗi vẫn tiếp tục, vui lòng 
                        <a href="{{ route('contact') }}" class="text-decoration-none">liên hệ với chúng tôi</a> 
                        để được hỗ trợ.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
