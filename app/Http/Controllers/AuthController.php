<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Hiển thị form đăng ký
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký tài khoản
     */
    public function register(RegisterRequest $request)
    {
        $this->authService->register($request);

        return redirect()->route('home')
            ->with('success', 'Đăng ký tài khoản thành công! Chào mừng bạn đến với SmartEdu.');
    }

    /**
     * Hiển thị form đăng nhập
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(LoginRequest $request)
    {
        if ($this->authService->login($request)) {
            return redirect()->intended(route('home'))
                ->with('success', 'Đăng nhập thành công!');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])
            ->withInput();
    }

    /**
     * Xử lý đăng xuất
     */
    public function logout(Request $request)
    {
        $this->authService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Đăng xuất thành công!');
    }
}
