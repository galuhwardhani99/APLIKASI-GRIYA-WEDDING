<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_is_redirected_to_login_without_being_authenticated(): void
    {
        $response = $this->post('/register', [
            'name' => 'Siti Aminah',
            'email' => 'SITI@example.com',
            'phone' => '+62 812-3456-7890',
            'address' => 'Jl. Melati No. 10, Bandung',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');
        $this->assertGuest();
        $this->assertDatabaseHas('users', [
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Melati No. 10, Bandung',
            'role' => 'client',
        ]);
    }

    public function test_registration_requires_email_phone_and_address(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Siti Aminah',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['email', 'phone', 'address']);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_rejects_a_phone_number_that_is_already_registered(): void
    {
        User::create([
            'name' => 'Pengguna Lama',
            'email' => 'lama@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Lama No. 1',
            'password' => 'password123',
        ]);

        $response = $this->from('/register')->post('/register', [
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'phone' => '+62 812-3456-7890',
            'address' => 'Jl. Melati No. 10, Bandung',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('phone');
        $this->assertDatabaseCount('users', 1);
    }
}
