<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = User::query()
            ->where('role', 'dokter')
            ->with('poli')
            ->orderBy('nama')
            ->get();

        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        $polis = Poli::query()->orderBy('nama_poli')->get();

        return view('admin.dokter.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_ktp' => ['required', 'string', 'max:16', 'unique:users,no_ktp'],
            'no_hp' => ['required', 'string', 'max:15'],
            'id_poli' => ['required', 'integer', 'exists:poli,id'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $data['role'] = 'dokter';
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function show(User $dokter)
    {
        abort_unless($dokter->role === 'dokter', 404);
        $dokter->load('poli');

        return view('admin.dokter.show', compact('dokter'));
    }

    public function edit(User $dokter)
    {
        abort_unless($dokter->role === 'dokter', 404);

        $polis = Poli::query()->orderBy('nama_poli')->get();

        return view('admin.dokter.edit', compact('dokter', 'polis'));
    }

    public function update(Request $request, User $dokter)
    {
        abort_unless($dokter->role === 'dokter', 404);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_ktp' => ['required', 'string', 'max:16', 'unique:users,no_ktp,'.$dokter->id],
            'no_hp' => ['required', 'string', 'max:15'],
            'id_poli' => ['required', 'integer', 'exists:poli,id'],
            'email' => ['required', 'email', 'unique:users,email,'.$dokter->id],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if (filled($data['password'] ?? null)) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $dokter->update($data);

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(User $dokter)
    {
        abort_unless($dokter->role === 'dokter', 404);

        $dokter->delete();

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil dihapus.');
    }
}
