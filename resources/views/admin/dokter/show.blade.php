<x-layouts.app title="Detail Dokter">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('dokter.index') }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200"><i class="fas fa-arrow-left"></i></a>
        <h1 class="text-2xl font-bold text-slate-800">Detail Dokter</h1>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div><dt class="text-sm text-slate-500">Nama Dokter</dt><dd class="mt-1 font-semibold">{{ $dokter->nama }}</dd></div>
            <div><dt class="text-sm text-slate-500">Poli</dt><dd class="mt-1 font-semibold">{{ $dokter->poli?->nama_poli ?? '—' }}</dd></div>
            <div><dt class="text-sm text-slate-500">Alamat</dt><dd class="mt-1 font-semibold">{{ $dokter->alamat ?: '—' }}</dd></div>
            <div><dt class="text-sm text-slate-500">No. KTP</dt><dd class="mt-1 font-semibold">{{ $dokter->no_ktp ?: '—' }}</dd></div>
            <div><dt class="text-sm text-slate-500">No. HP</dt><dd class="mt-1 font-semibold">{{ $dokter->no_hp ?: '—' }}</dd></div>
            <div><dt class="text-sm text-slate-500">Email</dt><dd class="mt-1 font-semibold">{{ $dokter->email }}</dd></div>
        </dl>
        <a href="{{ route('dokter.edit', $dokter) }}" class="btn mt-6 border-0 bg-amber-500 text-white hover:bg-amber-600">Edit Dokter</a>
    </div>
</x-layouts.app>
