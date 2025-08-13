<?php

namespace Tests\Feature;

use App\Models\UserManagement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_can_get_all_users(): void
    {
        UserManagement::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone_number' => '1234567890',
            'department' => 'IT'
        ]);

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'email',
                            'phone_number',
                            'is_active',
                            'department',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]);
    }

    public function test_can_create_user(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone_number' => '1234567890',
            'is_active' => true,
            'department' => 'IT'
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'User berhasil dibuat'
                ]);

        $this->assertDatabaseHas('users_management', [
            'email' => 'john@example.com'
        ]);
    }

    public function test_validates_user_creation(): void
    {
        $invalidData = [
            'name' => '',
            'email' => 'invalid-email',
            'phone_number' => '123',
            'department' => ''
        ];

        $response = $this->postJson('/api/users', $invalidData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['name', 'email', 'phone_number', 'department']);
    }

    public function test_can_show_user(): void
    {
        $user = UserManagement::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email
                    ]
                ]);
    }

    public function test_returns_404_for_nonexistent_user(): void
    {
        $response = $this->getJson('/api/users/999');

        $response->assertStatus(404)
                ->assertJson([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
    }

    public function test_can_update_user(): void
    {
        $user = UserManagement::factory()->create();
        
        $updateData = [
            'name' => 'Updated Name',
            'department' => 'HR'
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'User berhasil diupdate'
                ]);

        $this->assertDatabaseHas('users_management', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'department' => 'HR'
        ]);
    }

    public function test_can_delete_user(): void
    {
        $user = UserManagement::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'User berhasil dihapus'
                ]);

        $this->assertDatabaseMissing('users_management', [
            'id' => $user->id
        ]);
    }
}
