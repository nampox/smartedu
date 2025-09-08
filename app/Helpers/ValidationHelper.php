<?php

namespace App\Helpers;

use App\Services\ValidationService;

class ValidationHelper
{
    /**
     * Lấy thông báo validation nhanh
     */
    public static function message(string $rule, ?string $attribute = null): string
    {
        return ValidationService::getMessage($rule, $attribute);
    }

    /**
     * Lấy tên thuộc tính nhanh
     */
    public static function attribute(string $attribute): string
    {
        return ValidationService::getAttributeName($attribute);
    }

    /**
     * Tạo validation rules cho form thông thường
     */
    public static function rules(array $fields): array
    {
        $commonRules = ValidationService::getCommonRules();
        $result = [];

        // Lấy rules cho các field được chỉ định
        foreach ($fields as $field) {
            if (isset($commonRules[$field])) {
                $result[$field] = $commonRules[$field];
            }
        }

        return $result;
    }

    /**
     * Tạo validation messages cho form thông thường
     */
    public static function messages(array $fields): array
    {
        $rules = self::rules($fields);

        return ValidationService::makeMessages($rules);
    }

    /**
     * Validation rules cho user profile
     */
    public static function userProfileRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,11}$/'],
        ];
    }

    /**
     * Validation messages cho user profile
     */
    public static function userProfileMessages(): array
    {
        return ValidationService::makeMessages(self::userProfileRules());
    }

    /**
     * Validation rules cho admin quản lý user
     */
    public static function adminUserRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,11}$/'],
            'roles' => ['required', 'integer', 'in:0,1'],
        ];
    }

    /**
     * Validation messages cho admin quản lý user
     */
    public static function adminUserMessages(): array
    {
        return ValidationService::makeMessages(self::adminUserRules());
    }
}
