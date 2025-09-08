<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Role Names
    |--------------------------------------------------------------------------
    |
    | Định nghĩa tên các roles trong hệ thống
    |
    */
    'names' => [
        'admin' => 'Quản trị viên',
        'user' => 'Người dùng',
    ],

    /*
    |--------------------------------------------------------------------------
    | Role Descriptions
    |--------------------------------------------------------------------------
    |
    | Mô tả chi tiết cho từng role
    |
    */
    'descriptions' => [
        'admin' => 'Có toàn quyền quản lý hệ thống',
        'user' => 'Người dùng thông thường với quyền hạn cơ bản',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Role
    |--------------------------------------------------------------------------
    |
    | Role mặc định được gán cho user mới đăng ký
    |
    */
    'default' => 'user',

    /*
    |--------------------------------------------------------------------------
    | Permission Groups
    |--------------------------------------------------------------------------
    |
    | Nhóm các permissions theo chức năng
    |
    */
    'permission_groups' => [
        'users' => [
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
        ],
        'files' => [
            'upload-files',
            'view-files',
            'delete-files',
        ],
        'media' => [
            'upload-media',
            'view-media',
            'delete-media',
            'download-media',
            'manage-media',
        ],
        'query' => [
            'query-users',
            'query-media',
            'query-roles',
            'query-permissions',
        ],
        'admin' => [
            'view-admin-dashboard',
            'manage-roles',
            'manage-permissions',
        ],
        'content' => [
            'create-content',
            'edit-content',
            'delete-content',
            'publish-content',
        ],
    ],
];