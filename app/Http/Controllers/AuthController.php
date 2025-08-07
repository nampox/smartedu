<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
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
        // Tạo user mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'roles' => config('roles.user'), // Mặc định là user
        ]);

        // Tự động đăng nhập sau khi đăng ký
        Auth::login($user);

        // Redirect với thông báo thành công
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
        // Xác thực đăng nhập với Laravel Auth
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
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
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Đăng xuất thành công!');
    }
}
