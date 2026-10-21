<x-layouts.app title="Detail Pasien">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('pasien.index') }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200"><i class="fas fa-arrow-left"></i></a>
        <h1 class="text-2xl font-bold text-slate-800">Detail Pasien</h1>
    </div>
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div><dt class="text-sm text-slate-500">Nama</dt><dd class="mt-1 font-semibold">{{ $pasien->nama }}</dd></div>
            <div><dt class="text-sm text-slate-500">No. Rekam Medis</dt><dd class="mt-1 font-semibold">{{ $pasien->no_rm ?: '—' }}</dd></div>
            <div><dt class="text-sm text-slate-500">Email</dt><dd class="mt-1 font-semibold">{{ $pasien->email }}</dd></div>
            <div><dt class="text-sm text-slate-500">No. KTP</dt><dd class="mt-1 font-semibold">{{ $pasien->no_ktp ?: '—' }}</dd></div>
            <div><dt class="text-sm text-slate-500">No. HP</dt><dd class="mt-1 font-semibold">{{ $pasien->no_hp ?: '—' }}</dd></div>
            <div><dt class="text-sm text-slate-500">Alamat</dt><dd class="mt-1 font-semibold">{{ $pasien->alamat ?: '—' }}</dd></div>
        </dl>
        <a href="{{ route('pasien.edit', $pasien) }}" class="btn mt-6 border-0 bg-amber-500 text-white hover:bg-amber-600">Edit Pasien</a>
    </div>
</x-layouts.app>
