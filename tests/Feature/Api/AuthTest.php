<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;

    /**
     * Test API user registration
     */
    public function test_api_user_can_register()
    {
        // Xóa user cũ nếu có
        \App\Models\User::where('email', 'test@example.com')->delete();
        
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0123456787',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Đăng ký thành công',
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'role_name',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'phone' => '0123456787',
        ]);
    }

    /**
     * Test API user login
     */
    public function test_api_user_can_login()
    {
        // Xóa user cũ nếu có
        \App\Models\User::where('email', 'login@example.com')->delete();
        
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'phone' => '0987654321',
            'password' => bcrypt('password123'),
        ]);

        // Gán role user cho user
        $user->assignRole('user');

        $response = $this->postJson('/api/login', [
            'email' => 'login@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Đăng nhập thành công',
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'role_name',
                ],
            ]);
    }

    /**
     * Test API user logout
     */
    public function test_api_user_can_logout()
    {
        // Xóa user cũ nếu có
        \App\Models\User::where('email', 'logout@example.com')->delete();
        
        $user = User::factory()->create([
            'email' => 'logout@example.com',
            'phone' => '0999888777',
        ]);
        
        // Gán role user cho user
        $user->assignRole('user');
        $this->actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Đăng xuất thành công',
            ]);
    }

    /**
     * Test API get current user
     */
    public function test_api_can_get_current_user()
    {
        // Xóa user cũ nếu có
        \App\Models\User::where('email', 'me@example.com')->delete();
        
        $user = User::factory()->create([
            'email' => 'me@example.com',
            'phone' => '0888777666',
        ]);
        
        // Gán role user cho user
        $user->assignRole('user');
        $this->actingAs($user);

        $response = $this->getJson('/api/me');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'role_name',
                ],
            ]);
    }

    /**
     * Test API health check
     */
    public function test_api_health_check()
    {
        $response = $this->getJson('/api/health');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'ok',
            ])
            ->assertJsonStructure([
                'status',
                'timestamp',
                'version',
            ]);
    }

    /**
     * Test API registration validation
     */
    public function test_api_registration_validation()
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'invalid-email',
            'phone' => '',
            'password' => '123',
            'password_confirmation' => '456',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'password']);
    }

    /**
     * Test API login with invalid credentials
     */
    public function test_api_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Email hoặc mật khẩu không đúng',
            ]);
    }
}
