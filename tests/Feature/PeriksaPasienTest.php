<?php

namespace Tests\Feature;

use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeriksaPasienTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_open_registration_and_register_for_selected_clinic(): void
    {
        $poli = Poli::create(['nama_poli' => 'Poli Umum']);
        $dokter = User::create(['nama' => 'Dokter', 'email' => 'dokter@example.test', 'password' => bcrypt('password'), 'role' => 'dokter', 'id_poli' => $poli->id]);
        $pasien = User::create(['nama' => 'Pasien', 'email' => 'pasien@example.test', 'password' => bcrypt('password'), 'role' => 'pasien', 'no_rm' => '202603-005']);
        $jadwal = JadwalPeriksa::create(['id_dokter' => $dokter->id, 'hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00']);
        $this->actingAs($pasien)->get(route('pasien.daftar'))->assertOk()
            ->assertSee('Pendaftaran Poli')->assertSee('202603-005')->assertSee('Poli Umum')->assertSee('Pendaftaran Periksa');
        $this->post(route('pasien.daftar.submit'), ['id_poli' => $poli->id, 'id_jadwal' => $jadwal->id, 'keluhan' => 'Demam', 'id_pasien' => $dokter->id])
            ->assertSessionHasNoErrors()->assertSessionHas('message');
        $this->assertDatabaseHas('daftar_poli', ['id_pasien' => $pasien->id, 'id_jadwal' => $jadwal->id, 'no_antrian' => 1]);
        $other = Poli::create(['nama_poli' => 'Poli Gigi']);
        $this->post(route('pasien.daftar.submit'), ['id_poli' => $other->id, 'id_jadwal' => $jadwal->id])
            ->assertSessionHasErrors('id_jadwal');
    }

    public function test_doctor_can_open_examination_pages_and_save_examination(): void
    {
        $dokter = User::create(['nama' => 'Dokter Uji', 'email' => 'dokter@example.test', 'password' => bcrypt('password'), 'role' => 'dokter']);
        $pasien = User::create(['nama' => 'Pasien Uji', 'email' => 'pasien@example.test', 'password' => bcrypt('password'), 'role' => 'pasien']);
        $jadwal = JadwalPeriksa::create(['id_dokter' => $dokter->id, 'hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00']);
        $pendaftaran = DaftarPoli::create(['id_pasien' => $pasien->id, 'id_jadwal' => $jadwal->id, 'keluhan' => 'Demam', 'no_antrian' => 1]);
        $obat = Obat::create(['nama_obat' => 'Paracetamol', 'harga' => 5000]);

        $this->actingAs($dokter);
        $this->get(route('periksa-pasien.index'))->assertOk()->assertSee('Pasien Uji')->assertSee('Demam');
        $this->get(route('periksa-pasien.create', $pendaftaran->id))->assertOk()->assertSee('Paracetamol');
        $this->post(route('periksa-pasien.store'), ['id_daftar_poli' => $pendaftaran->id, 'obat_ids' => [$obat->id], 'catatan' => 'Istirahat', 'biaya_periksa' => 1])
            ->assertRedirect(route('periksa-pasien.index'))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('periksa', ['id_daftar_poli' => $pendaftaran->id, 'biaya_periksa' => 155000]);
        $this->assertDatabaseHas('detail_periksa', ['id_obat' => $obat->id]);
        $this->get(route('periksa-pasien.index'))->assertOk()->assertSee('Sudah Diperiksa');
        $periksa = \App\Models\Periksa::firstOrFail();
        $this->get(route('riwayat-pasien.index'))->assertOk()->assertSee('Pasien Uji');
        $this->get(route('riwayat-pasien.show', $periksa->id))->assertOk()
            ->assertSee('Informasi Pasien')->assertSee('Istirahat')->assertSee('Paracetamol')->assertSee('155.000');
        $this->get(route('riwayat-pasien.show', 999999))->assertNotFound();

        $this->actingAs($pasien)->get(route('periksa-pasien.index'))->assertForbidden();
        $this->get(route('riwayat-pasien.index'))->assertForbidden();
        $this->get(route('riwayat-pasien.show', $periksa->id))->assertForbidden();
        $other = User::create(['nama' => 'Dokter Lain', 'email' => 'other@example.test', 'password' => bcrypt('password'), 'role' => 'dokter']);
        $this->actingAs($other)->get(route('periksa-pasien.create', $pendaftaran->id))->assertNotFound();
        $this->get(route('riwayat-pasien.index'))->assertOk()->assertDontSee('Pasien Uji');
        $this->get(route('riwayat-pasien.show', $periksa->id))->assertNotFound();
        $this->post(route('periksa-pasien.store'), ['id_daftar_poli' => $pendaftaran->id])->assertNotFound();
    }
}
