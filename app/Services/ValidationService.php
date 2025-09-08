<?php

namespace App\Services;

class ValidationService
{
    /**
     * Lấy validation messages
     */
    public static function getMessages(): array
    {
        return config('validation.messages', []);
    }

    /**
     * Lấy field attributes
     */
    public static function getAttributes(): array
    {
        return config('validation.attributes', []);
    }

    /**
     * Lấy custom validation rules
     */
    public static function getCustomRules(): array
    {
        return config('validation.custom_rules', []);
    }

    /**
     * Lấy message cho một rule cụ thể
     */
    public static function getMessage(string $rule, ?string $attribute = null): string
    {
        $messages = self::getMessages();
        $attributes = self::getAttributes();

        $message = $messages[$rule] ?? 'Trường :attribute không hợp lệ';

        if ($attribute && isset($attributes[$attribute])) {
            $message = str_replace(':attribute', $attributes[$attribute], $message);
        }

        return $message;
    }

    /**
     * Lấy tên hiển thị của attribute
     */
    public static function getAttributeName(string $attribute): string
    {
        $attributes = self::getAttributes();

        return $attributes[$attribute] ?? $attribute;
    }

    /**
     * Tạo validation rules với custom messages
     */
    public static function makeRules(array $rules): array
    {
        return $rules;
    }

    /**
     * Tạo validation messages cho một form cụ thể
     */
    public static function makeMessages(array $fields = []): array
    {
        $messages = self::getMessages();
        $attributes = self::getAttributes();
        $result = [];

        foreach ($fields as $field => $rules) {
            $fieldName = $attributes[$field] ?? $field;

            foreach ($rules as $rule) {
                $ruleName = is_string($rule) ? $rule : $rule[0];
                $key = "{$field}.{$ruleName}";

                if (isset($messages[$ruleName])) {
                    $result[$key] = str_replace(':attribute', $fieldName, $messages[$ruleName]);
                }
            }
        }

        return $result;
    }

    /**
     * Lấy common validation rules
     */
    public static function getCommonRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,11}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ];
    }

    /**
     * Lấy validation rules cho đăng ký
     */
    public static function getRegisterRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,11}$/', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ];
    }

    /**
     * Lấy validation rules cho đăng nhập
     */
    public static function getLoginRules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Lấy validation messages cho đăng ký
     */
    public static function getRegisterMessages(): array
    {
        return self::makeMessages(self::getRegisterRules());
    }

    /**
     * Lấy validation messages cho đăng nhập
     */
    public static function getLoginMessages(): array
    {
        return self::makeMessages(self::getLoginRules());
    }
}
