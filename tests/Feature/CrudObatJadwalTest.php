<?php

namespace Tests\Feature;

use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrudObatJadwalTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $role): User
    {
        return User::create([
            'nama' => 'Pengguna Uji',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password123'),
            'role' => $role,
        ]);
    }

    public function test_admin_can_manage_obat_and_view_all_forms(): void
    {
        $this->actingAs($this->user('admin'));
        $this->get(route('obat.create'))->assertOk()->assertSee('Tambah Obat');
        $this->post(route('obat.store'), ['nama_obat' => 'Paracetamol', 'kemasan' => 'Strip', 'harga' => 5000])
            ->assertRedirect(route('obat.index'))->assertSessionHas('success');
        $obat = Obat::firstOrFail();
        $this->get(route('obat.index'))->assertOk()->assertSee('Paracetamol')->assertSee('Rp 5.000')->assertSee('Manajemen Obat');
        $this->get(route('obat.edit', $obat))->assertOk()->assertSee('Paracetamol');
        $this->put(route('obat.update', $obat), ['nama_obat' => 'Vitamin C', 'kemasan' => null, 'harga' => 10000])
            ->assertRedirect(route('obat.index'));
        $this->assertDatabaseHas('obat', ['id' => $obat->id, 'nama_obat' => 'Vitamin C', 'harga' => 10000]);
        $this->delete(route('obat.destroy', $obat))->assertRedirect(route('obat.index'));
        $this->assertDatabaseMissing('obat', ['id' => $obat->id]);
    }

    public function test_obat_rejects_invalid_fields_and_missing_records(): void
    {
        $this->actingAs($this->user('admin'));
        $this->post(route('obat.store'), ['harga' => -1, 'kemasan' => str_repeat('x', 36)])
            ->assertSessionHasErrors(['nama_obat', 'harga', 'kemasan']);
        $this->assertDatabaseCount('obat', 0);
        $this->get(route('obat.edit', 999))->assertNotFound();
    }

    public function test_dokter_can_manage_own_schedule_and_view_all_forms(): void
    {
        $dokter = $this->user('dokter');
        $this->actingAs($dokter);
        $this->get(route('jadwal-periksa.create'))->assertOk()->assertSee('Pilih hari');
        $data = ['hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00'];
        $this->post(route('jadwal-periksa.store'), $data + ['id_dokter' => 999])
            ->assertRedirect(route('jadwal-periksa.index'))->assertSessionHas('success');
        $jadwal = JadwalPeriksa::firstOrFail();
        $this->assertSame($dokter->id, $jadwal->id_dokter);
        $this->get(route('jadwal-periksa.index'))->assertOk()->assertSee('Senin')->assertSee('08:00');
        $this->get(route('jadwal-periksa.edit', $jadwal))->assertOk()->assertSee('08:00');
        $data['hari'] = 'Selasa';
        $this->put(route('jadwal-periksa.update', $jadwal), $data)->assertRedirect(route('jadwal-periksa.index'));
        $this->assertDatabaseHas('jadwal_periksa', ['id' => $jadwal->id, 'hari' => 'Selasa']);
        $this->delete(route('jadwal-periksa.destroy', $jadwal))->assertRedirect(route('jadwal-periksa.index'));
        $this->assertDatabaseMissing('jadwal_periksa', ['id' => $jadwal->id]);
    }

    public function test_schedule_list_is_ordered_and_other_doctors_cannot_access_records(): void
    {
        $owner = $this->user('dokter');
        foreach (['Minggu', 'Senin', 'Jumat'] as $hari) {
            JadwalPeriksa::create(['id_dokter' => $owner->id, 'hari' => $hari, 'jam_mulai' => '08:00', 'jam_selesai' => '12:00']);
        }
        $this->actingAs($owner)->get(route('jadwal-periksa.index'))->assertOk()->assertSeeInOrder(['Senin', 'Jumat', 'Minggu']);
        $jadwal = JadwalPeriksa::firstOrFail();
        $this->actingAs($this->user('dokter'));
        $this->get(route('jadwal-periksa.index'))->assertOk()->assertDontSee('08:00');
        $this->get(route('jadwal-periksa.edit', $jadwal))->assertNotFound();
        $this->put(route('jadwal-periksa.update', $jadwal), [])->assertNotFound();
        $this->delete(route('jadwal-periksa.destroy', $jadwal))->assertNotFound();
        $this->assertDatabaseCount('jadwal_periksa', 3);
    }

    public function test_schedule_rejects_invalid_day_and_time_range(): void
    {
        $this->actingAs($this->user('dokter'));
        $this->post(route('jadwal-periksa.store'), ['hari' => 'Invalid', 'jam_mulai' => '12:00', 'jam_selesai' => '08:00'])
            ->assertSessionHasErrors(['hari', 'jam_selesai']);
        $this->post(route('jadwal-periksa.store'), ['hari' => 'Senin', 'jam_mulai' => 'invalid'])
            ->assertSessionHasErrors(['jam_mulai', 'jam_selesai']);
        $this->assertDatabaseCount('jadwal_periksa', 0);
    }

    public function test_crud_routes_require_correct_role(): void
    {
        $obat = Obat::create(['nama_obat' => 'Obat Uji', 'harga' => 5000]);
        foreach (['obat', 'jadwal-periksa'] as $resource) {
            $this->get(route($resource.'.index'))->assertRedirect(route('login'));
        }
        foreach (['admin', 'dokter', 'pasien'] as $role) {
            $this->actingAs($this->user($role));
            foreach (['obat' => 'admin', 'jadwal-periksa' => 'dokter'] as $resource => $allowed) {
                if ($role === $allowed) {
                    continue;
                }
                $this->get(route($resource.'.index'))->assertForbidden();
                $this->get(route($resource.'.create'))->assertForbidden();
                $this->post(route($resource.'.store'), [])->assertForbidden();
                $id = $resource === 'obat' ? $obat->id : 999;
                $this->get(route($resource.'.edit', $id))->assertForbidden();
                $this->put(route($resource.'.update', $id), [])->assertForbidden();
                $this->delete(route($resource.'.destroy', $id))->assertForbidden();
            }
        }
    }
}
