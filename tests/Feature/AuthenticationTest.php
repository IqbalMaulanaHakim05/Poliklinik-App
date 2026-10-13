<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private function registrationData(): array
    {
        return ['nama' => 'Pasien Uji', 'alamat' => 'Alamat pengujian', 'no_ktp' => '9999999999999001', 'no_hp' => '080000000001', 'email' => 'test@example.test', 'password' => 'password123', 'password_confirmation' => 'password123'];
    }

    public function test_registration_creates_patient_with_hashed_password(): void
    {
        $this->post('/register', $this->registrationData() + ['role' => 'admin'])->assertRedirect('/login')->assertSessionHas('success');
        $user = User::where('email', 'test@example.test')->firstOrFail();
        $this->assertSame('pasien', $user->role);
        $this->assertNotEmpty($user->no_rm);
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->get('/login')->assertSee('Registrasi berhasil! Silakan login.');
    }

    public function test_registration_rejects_mismatched_confirmation(): void
    {
        $data = $this->registrationData();
        $data['password_confirmation'] = 'different';
        $this->post('/register', $data)->assertSessionHasErrors('password');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_rejects_duplicate_email_and_identity(): void
    {
        $this->post('/register', $this->registrationData());
        $this->post('/register', $this->registrationData())->assertSessionHasErrors(['email', 'no_ktp']);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_login_redirects_each_role_and_blocks_other_dashboards(): void
    {
        foreach (['admin', 'dokter', 'pasien'] as $role) {
            $user = User::create(['nama' => $role, 'email' => $role.'@example.test', 'password' => Hash::make('password123'), 'role' => $role]);
            $this->post('/login', ['email' => $user->email, 'password' => 'password123'])->assertRedirect('/'.$role.'/dashboard');
            $this->assertAuthenticatedAs($user);
            $this->get('/'.$role.'/dashboard')->assertOk();
            $this->get('/dashboard')->assertRedirect('/'.$role.'/dashboard');
            foreach (array_diff(['admin', 'dokter', 'pasien'], [$role]) as $otherRole) {
                $this->get('/'.$otherRole.'/dashboard')->assertForbidden();
            }
            $this->post('/logout')->assertRedirect('/login');
            $this->assertGuest();
        }
    }

    public function test_login_rejects_invalid_credentials(): void
    {
        $this->post('/login', ['email' => 'unknown@example.test', 'password' => 'wrong'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        foreach (['admin', 'dokter', 'pasien'] as $role) {
            $this->get('/'.$role.'/dashboard')->assertRedirect('/login');
        }
    }
}
