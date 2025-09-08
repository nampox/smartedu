@extends('layouts.app')

@section('title', 'Admin Dashboard - SmartEdu')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Admin Dashboard</h1>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.refresh-cache') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-arrow-clockwise"></i> Refresh Cache
                    </a>
                    <a href="{{ route('logs.index') }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-file-text"></i> Log Viewer
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($userStats['total_users'] ?? 0) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Admin Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($userStats['admin_users'] ?? 0) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-shield-check text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Users Hôm Nay
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($userStats['new_users_today'] ?? 0) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-plus text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Users Tháng Này
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($userStats['new_users_this_month'] ?? 0) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-month text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Statistics -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống Kê Logs</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <div class="text-danger">
                                <i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i>
                                <div class="h4">{{ $logStats['error_logs'] ?? 0 }}</div>
                                <small>Errors</small>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="text-warning">
                                <i class="bi bi-exclamation-circle" style="font-size: 2rem;"></i>
                                <div class="h4">{{ $logStats['warning_logs'] ?? 0 }}</div>
                                <small>Warnings</small>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="text-info">
                                <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                                <div class="h4">{{ $logStats['info_logs'] ?? 0 }}</div>
                                <small>Info</small>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="text-secondary">
                                <i class="bi bi-bug" style="font-size: 2rem;"></i>
                                <div class="h4">{{ $logStats['debug_logs'] ?? 0 }}</div>
                                <small>Debug</small>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="text-primary">
                                <i class="bi bi-list-ul" style="font-size: 2rem;"></i>
                                <div class="h4">{{ $logStats['total_logs'] ?? 0 }}</div>
                                <small>Tổng Logs</small>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="{{ route('logs.index') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> Xem Logs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-people"></i><br>
                                Quản Lý Users
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('logs.index') }}" class="btn btn-outline-info w-100">
                                <i class="bi bi-file-text"></i><br>
                                Xem Logs
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.refresh-cache') }}" class="btn btn-outline-warning w-100">
                                <i class="bi bi-arrow-clockwise"></i><br>
                                Refresh Cache
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-house"></i><br>
                                Về Trang Chủ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
</style>
@endsection
