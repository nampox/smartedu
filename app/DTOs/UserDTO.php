<?php

namespace App\DTOs;

class UserDTO extends BaseDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?int $roles = null,
        public ?string $created_at = null,
        public ?string $updated_at = null
    ) {}

    /**
     * Create from User model
     */
    public static function fromModel(\App\Models\User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            phone: $user->phone,
            roles: $user->roles,
            created_at: $user->created_at?->toDateTimeString(),
            updated_at: $user->updated_at?->toDateTimeString()
        );
    }

    /**
     * Get role name
     */
    public function getRoleName(): string
    {
        return match ($this->roles) {
            config('roles.admin') => 'Admin',
            config('roles.user') => 'User',
            default => 'Unknown'
        };
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->roles === config('roles.admin');
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->roles === config('roles.user');
    }
}
