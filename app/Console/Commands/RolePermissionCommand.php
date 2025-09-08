<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:manage {action} {--role=} {--permission=} {--user=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quản lý roles và permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'list-roles':
                $this->listRoles();
                break;
            case 'list-permissions':
                $this->listPermissions();
                break;
            case 'assign-role':
                $this->assignRole();
                break;
            case 'assign-permission':
                $this->assignPermission();
                break;
            case 'sync-permissions':
                $this->syncPermissions();
                break;
            default:
                $this->error('Action không hợp lệ. Các action có sẵn: list-roles, list-permissions, assign-role, assign-permission, sync-permissions');
        }
    }

    private function listRoles()
    {
        $this->info('Danh sách Roles:');
        $roles = Role::with('permissions')->get();
        
        foreach ($roles as $role) {
            $this->line("- {$role->name} (ID: {$role->id})");
            $permissions = $role->permissions->pluck('name')->toArray();
            if (!empty($permissions)) {
                $this->line("  Permissions: " . implode(', ', $permissions));
            }
        }
    }

    private function listPermissions()
    {
        $this->info('Danh sách Permissions:');
        $permissions = Permission::all();
        
        foreach ($permissions as $permission) {
            $this->line("- {$permission->name} (ID: {$permission->id})");
        }
    }

    private function assignRole()
    {
        $roleName = $this->option('role');
        $userEmail = $this->option('user');

        if (!$roleName || !$userEmail) {
            $this->error('Vui lòng cung cấp --role và --user');
            return;
        }

        $user = User::where('email', $userEmail)->first();
        if (!$user) {
            $this->error("Không tìm thấy user với email: {$userEmail}");
            return;
        }

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error("Không tìm thấy role: {$roleName}");
            return;
        }

        $user->assignRole($role);
        $this->info("Đã gán role '{$roleName}' cho user '{$userEmail}'");
    }

    private function assignPermission()
    {
        $permissionName = $this->option('permission');
        $roleName = $this->option('role');

        if (!$permissionName || !$roleName) {
            $this->error('Vui lòng cung cấp --permission và --role');
            return;
        }

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error("Không tìm thấy role: {$roleName}");
            return;
        }

        $permission = Permission::where('name', $permissionName)->first();
        if (!$permission) {
            $this->error("Không tìm thấy permission: {$permissionName}");
            return;
        }

        $role->givePermissionTo($permission);
        $this->info("Đã gán permission '{$permissionName}' cho role '{$roleName}'");
    }

    private function syncPermissions()
    {
        $this->info('Đang đồng bộ permissions...');
        
        // Chạy seeder để tạo lại permissions
        $this->call('db:seed', ['--class' => 'RolePermissionSeeder']);
        
        $this->info('Đã đồng bộ permissions thành công!');
    }
}