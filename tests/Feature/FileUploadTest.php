<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /**
     * Test single file upload
     */
    public function test_can_upload_single_file()
    {
        // Tạo user và gán role
        $user = \App\Models\User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('test.jpg', 1000, 'image/jpeg');

        $response = $this->postJson('/api/upload', [
            'file' => $file,
            'folder' => 'test-uploads',
            'is_image' => true,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'File uploaded successfully',
            ])
            ->assertJsonStructure([
                'data' => [
                    'original_name',
                    'file_name',
                    'file_path',
                    'file_url',
                    'file_size',
                    'mime_type',
                    'extension',
                ],
            ]);

        // Assert file was stored
        $this->assertTrue(Storage::disk('public')->exists('test-uploads/' . $response->json('data.file_name')));
    }

    /**
     * Test multiple file upload
     */
    public function test_can_upload_multiple_files()
    {
        // Tạo user và gán role
        $user = \App\Models\User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $files = [
            UploadedFile::fake()->create('test1.jpg', 1000, 'image/jpeg'),
            UploadedFile::fake()->create('test2.jpg', 1000, 'image/jpeg'),
        ];

        $response = $this->postJson('/api/upload-multiple', [
            'files' => $files,
            'folder' => 'test-uploads',
            'is_image' => true,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Files uploaded successfully',
            ])
            ->assertJsonCount(2, 'data');

        // Assert files were stored
        foreach ($response->json('data') as $fileData) {
            $this->assertTrue(Storage::disk('public')->exists($fileData['file_path']));
        }
    }

    /**
     * Test file upload validation
     */
    public function test_file_upload_validation()
    {
        // Tạo user và gán role
        $user = \App\Models\User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $response = $this->postJson('/api/upload', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['file']);
    }

    /**
     * Test file upload with invalid file type
     */
    public function test_file_upload_invalid_type()
    {
        // Tạo user và gán role
        $user = \App\Models\User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('test.txt', 1000, 'text/plain');

        $response = $this->postJson('/api/upload', [
            'file' => $file,
            'is_image' => true,
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    /**
     * Test file upload with oversized file
     */
    public function test_file_upload_oversized()
    {
        // Tạo user và gán role
        $user = \App\Models\User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('test.jpg', 15000, 'image/jpeg'); // 15MB

        $response = $this->postJson('/api/upload', [
            'file' => $file,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['file']);
    }

    /**
     * Test file deletion
     */
    public function test_can_delete_file()
    {
        // Tạo user và gán role
        $user = \App\Models\User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        // First upload a file
        $file = UploadedFile::fake()->create('test.jpg', 1000, 'image/jpeg');
        $uploadResponse = $this->postJson('/api/upload', [
            'file' => $file,
            'folder' => 'test-uploads',
        ]);

        $filePath = $uploadResponse->json('data.file_path');

        // Then delete it
        $response = $this->deleteJson('/api/files', [
            'file_path' => $filePath,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'File deleted successfully',
            ]);

        // Assert file was deleted
        $this->assertFalse(Storage::disk('public')->exists($filePath));
    }

    /**
     * Test file info retrieval
     */
    public function test_can_get_file_info()
    {
        // Tạo user và gán role
        $user = \App\Models\User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        // First upload a file
        $file = UploadedFile::fake()->create('test.jpg', 1000, 'image/jpeg');
        $uploadResponse = $this->postJson('/api/upload', [
            'file' => $file,
            'folder' => 'test-uploads',
        ]);

        $filePath = $uploadResponse->json('data.file_path');

        // Then get file info
        $response = $this->getJson('/api/files/info?file_path=' . $filePath);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'data' => [
                    'file_path',
                    'file_url',
                    'file_size',
                    'mime_type',
                    'last_modified',
                ],
            ]);
    }

    /**
     * Test file URL with thumbnail
     */
    public function test_can_get_file_url_with_thumbnail()
    {
        // Tạo user và gán role
        $user = \App\Models\User::factory()->create();
        $user->assignRole('user');
        $this->actingAs($user);

        // First upload a file
        $file = UploadedFile::fake()->create('test.jpg', 1000, 'image/jpeg');
        $uploadResponse = $this->postJson('/api/upload', [
            'file' => $file,
            'folder' => 'test-uploads',
            'is_image' => true,
        ]);

        $filePath = $uploadResponse->json('data.file_path');

        // Then get file URL
        $response = $this->getJson('/api/files/url?file_path=' . $filePath . '&size=thumb');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'data' => [
                    'url',
                    'size',
                ],
            ]);
    }
}