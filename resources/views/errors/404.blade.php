@extends('layouts.app')

@section('title', '404 - Trang không tìm thấy')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="py-5">
                <!-- 404 Icon -->
                <div class="mb-4">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 5rem;"></i>
                </div>
                
                <!-- Error Message -->
                <h1 class="display-1 fw-bold text-primary">404</h1>
                <h2 class="h3 mb-3">Trang không tìm thấy</h2>
                <p class="lead text-muted mb-4">
                    Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.
                </p>
                
                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="bi bi-house"></i> Về trang chủ
                    </a>
                    <button onclick="history.back()" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </button>
                </div>
                
                <!-- Help Text -->
                <div class="mt-5">
                    <p class="text-muted small">
                        Nếu bạn cho rằng đây là lỗi, vui lòng 
                        <a href="{{ route('contact') }}" class="text-decoration-none">liên hệ với chúng tôi</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
