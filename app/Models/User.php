<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'roles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Kiểm tra user có phải là admin không
     */
    public function isAdmin(): bool
    {
        return $this->roles === config('roles.admin');
    }

    /**
     * Kiểm tra user có phải là user thường không
     */
    public function isUser(): bool
    {
        return $this->roles === config('roles.user');
    }

    /**
     * Lấy tên role
     */
    public function getRoleName(): string
    {
        return config('roles.names.' . $this->roles, 'Unknown');
    }

    /**
     * Lấy mô tả role
     */
    public function getRoleDescription(): string
    {
        return config('roles.descriptions.' . $this->roles, 'Không xác định');
    }
}
