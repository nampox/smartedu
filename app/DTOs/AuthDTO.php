<?php

namespace App\DTOs;

class AuthDTO extends BaseDTO
{
    public function __construct(
        public ?string $email = null,
        public ?string $password = null,
        public ?bool $remember = false,
        public ?string $name = null,
        public ?string $phone = null,
        public ?string $password_confirmation = null
    ) {}

    /**
     * Create from login request
     */
    public static function fromLoginRequest(\App\Http\Requests\LoginRequest $request): self
    {
        return new self(
            email: $request->email,
            password: $request->password,
            remember: $request->has('remember')
        );
    }

    /**
     * Create from register request
     */
    public static function fromRegisterRequest(\App\Http\Requests\RegisterRequest $request): self
    {
        return new self(
            name: $request->name,
            email: $request->email,
            phone: $request->phone,
            password: $request->password,
            password_confirmation: $request->password_confirmation
        );
    }

    /**
     * Get credentials for authentication
     */
    public function getCredentials(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    /**
     * Get user data for registration
     */
    public function getUserData(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
        ];
    }
}
