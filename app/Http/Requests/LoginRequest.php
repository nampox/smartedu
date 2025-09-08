<?php

namespace App\Http\Requests;

use App\Services\ValidationService;

class LoginRequest extends BaseFormRequest
{
    /**
     * Lấy các quy tắc validation cho request đăng nhập
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return ValidationService::getLoginRules();
    }

    /**
     * Lấy thông báo lỗi tùy chỉnh cho validator
     */
    public function messages(): array
    {
        return ValidationService::getLoginMessages();
    }
}
