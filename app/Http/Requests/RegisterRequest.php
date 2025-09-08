<?php

namespace App\Http\Requests;

use App\Services\ValidationService;

class RegisterRequest extends BaseFormRequest
{
    /**
     * Lấy các quy tắc validation cho request đăng ký
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return ValidationService::getRegisterRules();
    }

    /**
     * Lấy thông báo lỗi tùy chỉnh cho validator
     */
    public function messages(): array
    {
        return ValidationService::getRegisterMessages();
    }
}
