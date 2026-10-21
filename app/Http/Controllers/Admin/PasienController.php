<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = User::query()
            ->where('role', 'pasien')
            ->orderBy('nama')
            ->get();

        return view('admin.pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('admin.pasien.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_ktp' => ['required', 'string', 'max:16', 'unique:users,no_ktp'],
            'no_hp' => ['required', 'string', 'max:15'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $lastPasien = User::query()->where('role', 'pasien')->orderByDesc('id')->first();
        $nextNumber = $lastPasien ? $lastPasien->id + 1 : 1;
        $data['no_rm'] = date('Ym').'-'.str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
        $data['role'] = 'pasien';
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function show(User $pasien)
    {
        abort_unless($pasien->role === 'pasien', 404);

        return view('admin.pasien.show', compact('pasien'));
    }

    public function edit(User $pasien)
    {
        abort_unless($pasien->role === 'pasien', 404);

        return view('admin.pasien.edit', compact('pasien'));
    }

    public function update(Request $request, User $pasien)
    {
        abort_unless($pasien->role === 'pasien', 404);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_ktp' => ['required', 'string', 'max:16', 'unique:users,no_ktp,'.$pasien->id],
            'no_hp' => ['required', 'string', 'max:15'],
            'email' => ['required', 'email', 'unique:users,email,'.$pasien->id],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if (filled($data['password'] ?? null)) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $pasien->update($data);

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(User $pasien)
    {
        abort_unless($pasien->role === 'pasien', 404);

        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}
