<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        DaftarPoli::whereHas('jadwalPeriksa', fn ($query) => $query->where('id_dokter', Auth::id()))
            ->findOrFail($id);
        $obats = Obat::all();

        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_daftar_poli' => 'required|integer',
            'obat_ids' => 'nullable|array',
            'obat_ids.*' => 'integer|distinct|exists:obat,id',
            'catatan' => 'nullable|string',
        ]);

        $pendaftaran = DaftarPoli::whereHas('jadwalPeriksa', fn ($query) => $query->where('id_dokter', Auth::id()))
            ->findOrFail($data['id_daftar_poli']);
        $obatIds = $data['obat_ids'] ?? [];

        DB::transaction(function () use ($pendaftaran, $data, $obatIds) {
            $periksa = Periksa::create([
                'id_daftar_poli' => $pendaftaran->id,
                'tgl_periksa' => now(),
                'catatan' => $data['catatan'] ?? null,
                'biaya_periksa' => Obat::whereIn('id', $obatIds)->sum('harga') + 150000,
            ]);

            if (is_array($obatIds)) {
                foreach ($obatIds as $idObat) {
                    DetailPeriksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat' => $idObat,
                    ]);
                }
            }
        });

        return redirect()
            ->route('periksa-pasien.index')
            ->with('success', 'Data periksa berhasil disimpan.');
    }
}
