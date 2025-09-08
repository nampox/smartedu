<?php

namespace App\Http\Requests;

use App\Services\ValidationService;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest
{
    /**
     * Xác định user có được phép thực hiện request này không
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Lấy tên thuộc tính tùy chỉnh cho lỗi validator
     */
    public function attributes(): array
    {
        return ValidationService::getAttributes();
    }

    /**
     * Lấy thông báo validation từ config
     */
    protected function getValidationMessages(): array
    {
        return ValidationService::getMessages();
    }

    /**
     * Lấy tên thuộc tính field từ config
     */
    protected function getFieldAttributes(): array
    {
        return ValidationService::getAttributes();
    }

    /**
     * Tạo thông báo tùy chỉnh cho các field cụ thể
     */
    protected function createMessages(array $fields): array
    {
        return ValidationService::makeMessages($fields);
    }
}
