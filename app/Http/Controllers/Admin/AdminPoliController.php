<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class AdminPoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polis = Poli::query()->orderBy('nama_poli')->get();

        return view('admin.polis.index', compact('polis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.polis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_poli' => ['required', 'string', 'max:25'],
            'keterangan' => ['required', 'string'],
        ]);

        Poli::create($validated);

        return redirect()->route('polis.index')->with('success', 'Data poli berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $poli = Poli::findOrFail($id);

        return view('admin.polis.show', compact('poli'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $poli = Poli::findOrFail($id);

        return view('admin.polis.edit', compact('poli'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_poli' => ['required', 'string', 'max:25'],
            'keterangan' => ['required', 'string'],
        ]);

        Poli::findOrFail($id)->update($validated);

        return redirect()->route('polis.index')->with('success', 'Data poli berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Poli::findOrFail($id)->delete();

        return redirect()->route('polis.index')->with('success', 'Data poli berhasil dihapus.');
    }
}
