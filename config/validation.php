<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Messages
    |--------------------------------------------------------------------------
    |
    | Định nghĩa tất cả validation messages cho toàn bộ ứng dụng
    |
    */

    'messages' => [
        // Common messages
        'required' => 'Trường :attribute là bắt buộc',
        'email' => 'Trường :attribute phải là email hợp lệ',
        'unique' => 'Trường :attribute đã được sử dụng',
        'min' => 'Trường :attribute phải có ít nhất :min ký tự',
        'max' => 'Trường :attribute không được vượt quá :max ký tự',
        'confirmed' => 'Trường :attribute xác nhận không khớp',
        'string' => 'Trường :attribute phải là chuỗi ký tự',
        'numeric' => 'Trường :attribute phải là số',
        'integer' => 'Trường :attribute phải là số nguyên',
        'boolean' => 'Trường :attribute phải là true hoặc false',
        'date' => 'Trường :attribute phải là ngày hợp lệ',
        'url' => 'Trường :attribute phải là URL hợp lệ',
        'image' => 'Trường :attribute phải là file hình ảnh',
        'file' => 'Trường :attribute phải là file',
        'mimes' => 'Trường :attribute phải có định dạng: :values',
        'size' => 'Trường :attribute phải có kích thước :size',
        'between' => 'Trường :attribute phải nằm trong khoảng :min và :max',
        'in' => 'Trường :attribute phải là một trong: :values',
        'not_in' => 'Trường :attribute không được là: :values',
        'regex' => 'Trường :attribute không đúng định dạng',
        'alpha' => 'Trường :attribute chỉ được chứa chữ cái',
        'alpha_num' => 'Trường :attribute chỉ được chứa chữ cái và số',
        'alpha_dash' => 'Trường :attribute chỉ được chứa chữ cái, số, gạch ngang và gạch dưới',
        'digits' => 'Trường :attribute phải có đúng :digits chữ số',
        'digits_between' => 'Trường :attribute phải có từ :min đến :max chữ số',
        'phone' => 'Trường :attribute phải là số điện thoại hợp lệ',
        'password' => 'Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt',
        'file' => 'Trường :attribute phải là file hợp lệ',
        'file.max' => 'File không được vượt quá :max KB',
        'file.mimes' => 'File phải có định dạng: :values',
    ],

    /*
    |--------------------------------------------------------------------------
    | Field Names
    |--------------------------------------------------------------------------
    |
    | Định nghĩa tên hiển thị cho các trường
    |
    */

    'attributes' => [
        'name' => 'họ và tên',
        'email' => 'email',
        'phone' => 'số điện thoại',
        'password' => 'mật khẩu',
        'password_confirmation' => 'xác nhận mật khẩu',
        'remember' => 'ghi nhớ đăng nhập',
        'file' => 'file',
        'folder' => 'thư mục',
        'is_image' => 'loại hình ảnh',
        'title' => 'tiêu đề',
        'content' => 'nội dung',
        'description' => 'mô tả',
        'price' => 'giá',
        'quantity' => 'số lượng',
        'status' => 'trạng thái',
        'role' => 'vai trò',
        'permission' => 'quyền',
        'category' => 'danh mục',
        'tags' => 'thẻ',
        'image' => 'hình ảnh',
        'file' => 'tệp',
        'date' => 'ngày',
        'time' => 'thời gian',
        'address' => 'địa chỉ',
        'city' => 'thành phố',
        'country' => 'quốc gia',
        'zip_code' => 'mã bưu điện',
        'website' => 'website',
        'bio' => 'tiểu sử',
        'avatar' => 'ảnh đại diện',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Rules
    |--------------------------------------------------------------------------
    |
    | Định nghĩa các validation rules tùy chỉnh
    |
    */

    'custom_rules' => [
        'phone' => 'regex:/^[0-9]{10,11}$/',
        'password_strong' => 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
        'vietnamese_name' => 'regex:/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂÂÊÔưăâêô\s]+$/',
    ],

    /*
    |--------------------------------------------------------------------------
    | Form Rules
    |--------------------------------------------------------------------------
    |
    | Định nghĩa các rules cho từng form
    |
    */

    'rules' => [
        'register' => [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
        'login' => [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ],
        'file_upload' => [
            'file' => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,txt,xlsx,xls'],
            'folder' => ['sometimes', 'string', 'max:255'],
            'is_image' => ['sometimes', 'boolean'],
        ],
    ],
];
