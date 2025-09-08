<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Tạo permissions
        $permissions = [
            // User permissions
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            
            // File upload permissions
            'upload-files',
            'view-files',
            'delete-files',
            
            // Media permissions
            'upload-media',
            'view-media',
            'delete-media',
            'download-media',
            'manage-media',
            
            // Query builder permissions
            'query-users',
            'query-media',
            'query-roles',
            'query-permissions',
            
            // Admin permissions
            'view-admin-dashboard',
            'manage-roles',
            'manage-permissions',
            
            // Content permissions
            'create-content',
            'edit-content',
            'delete-content',
            'publish-content',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Tạo roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Gán permissions cho admin (tất cả permissions)
        $adminRole->givePermissionTo(Permission::all());

        // Gán permissions cho user (chỉ một số permissions cơ bản)
        $userRole->givePermissionTo([
            'upload-files',
            'view-files',
            'upload-media',
            'view-media',
            'download-media',
            'query-users',
            'query-media',
            'create-content',
            'edit-content',
        ]);
    }
}