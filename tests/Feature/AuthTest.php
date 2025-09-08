<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;

    /**
     * Test user registration
     */
    public function test_user_can_register()
    {
        // Xóa user cũ nếu có
        \App\Models\User::where('email', 'test@example.com')->delete();
        
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0123456788',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
            'phone' => '0123456788',
        ]);
    }

    /**
     * Test user login
     */
    public function test_user_can_login()
    {
        // Xóa user cũ nếu có
        \App\Models\User::where('email', 'test@example.com')->delete();
        
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'phone' => '0987654321',
            'password' => bcrypt('password123'),
        ]);

        // Gán role user cho user
        $user->assignRole('user');

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    /**
     * Test user logout
     */
    public function test_user_can_logout()
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

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Test admin middleware protection
     */
    public function test_admin_route_requires_authentication()
    {
        $response = $this->get('/log');
        $response->assertRedirect('/login');
    }

    /**
     * Test admin middleware blocks regular users
     */
    public function test_admin_route_blocks_regular_users()
    {
        // Xóa user cũ nếu có
        \App\Models\User::where('email', 'regular@example.com')->delete();
        
        $user = User::factory()->create([
            'email' => 'regular@example.com',
            'phone' => '0888777666',
        ]);
        
        // Gán role user cho user (regular user)
        $user->assignRole('user');
        $this->actingAs($user);

        $response = $this->get('/log');
        $response->assertRedirect('/');
    }

    /**
     * Test admin middleware allows admin users
     */
    public function test_admin_route_allows_admin_users()
    {
        // Xóa user cũ nếu có
        \App\Models\User::where('email', 'admin@example.com')->delete();
        
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'phone' => '0777666555',
        ]);
        
        // Gán role admin cho user
        $admin->assignRole('admin');
        $this->actingAs($admin);

        $response = $this->get('/log');
        $response->assertStatus(200);
    }

    /**
     * Test registration validation
     */
    public function test_registration_requires_valid_email()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'phone' => '0123456789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test login validation
     */
    public function test_login_requires_valid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
