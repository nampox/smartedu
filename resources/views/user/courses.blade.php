@extends('layouts.app')

@section('title', 'Khóa học - SmartEdu')

@section('content')
    <!-- Page Header -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Khóa học</h1>
                    <p class="lead">
                        Khám phá hàng nghìn khóa học chất lượng cao từ các chuyên gia hàng đầu
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="d-flex gap-2">
                        <select class="form-select" style="max-width: 200px;">
                            <option>Tất cả danh mục</option>
                            <option>Lập trình</option>
                            <option>Thiết kế</option>
                            <option>Marketing</option>
                            <option>Kinh doanh</option>
                        </select>
                        <select class="form-select" style="max-width: 150px;">
                            <option>Sắp xếp</option>
                            <option>Mới nhất</option>
                            <option>Phổ biến</option>
                            <option>Đánh giá cao</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm khóa học...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @for ($i = 1; $i <= 12; $i++)
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
            
            <!-- Pagination -->
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Trước</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Sau</a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
@endsection 