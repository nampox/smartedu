<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Hiển thị trang chủ
     */
    public function home()
    {
        return view('user.home');
    }

    /**
     * Hiển thị trang khóa học
     */
    public function courses()
    {
        return view('user.courses');
    }

    /**
     * Hiển thị trang giảng viên
     */
    public function teachers()
    {
        return view('user.teachers');
    }

    /**
     * Hiển thị trang giới thiệu
     */
    public function about()
    {
        return view('user.about');
    }

    /**
     * Hiển thị trang liên hệ
     */
    public function contact()
    {
        return view('user.contact');
    }
}
