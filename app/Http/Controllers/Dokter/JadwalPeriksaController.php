<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    private const HARI = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    public function index()
    {
        $jadwals = JadwalPeriksa::query()
            ->where('id_dokter', Auth::id())
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get();

        return view('dokter.jadwal-periksa.index', compact('jadwals'));
    }

    public function create()
    {
        return view('dokter.jadwal-periksa.create', ['hariOptions' => self::HARI]);
    }

    public function store(Request $request)
    {
        $data = $this->validateSchedule($request);
        $data['id_dokter'] = Auth::id();

        JadwalPeriksa::create($data);

        return redirect()->route('jadwal-periksa.index')->with('success', 'Jadwal periksa berhasil ditambahkan.');
    }

    public function edit(string $jadwal_periksa)
    {
        $jadwal = $this->findOwnSchedule($jadwal_periksa);

        return view('dokter.jadwal-periksa.edit', [
            'jadwal' => $jadwal,
            'hariOptions' => self::HARI,
        ]);
    }

    public function update(Request $request, string $jadwal_periksa)
    {
        $jadwal = $this->findOwnSchedule($jadwal_periksa);
        $jadwal->update($this->validateSchedule($request));

        return redirect()->route('jadwal-periksa.index')->with('success', 'Jadwal periksa berhasil diperbarui.');
    }

    public function destroy(string $jadwal_periksa)
    {
        $this->findOwnSchedule($jadwal_periksa)->delete();

        return redirect()->route('jadwal-periksa.index')->with('success', 'Jadwal periksa berhasil dihapus.');
    }

    private function validateSchedule(Request $request): array
    {
        return $request->validate([
            'hari' => ['required', 'in:'.implode(',', self::HARI)],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ]);
    }

    private function findOwnSchedule(string $id): JadwalPeriksa
    {
        return JadwalPeriksa::query()
            ->where('id_dokter', Auth::id())
            ->findOrFail($id);
    }
}
