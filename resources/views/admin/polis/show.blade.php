<x-layouts.app title="Detail Poli">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('polis.index') }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200"><i class="fas fa-arrow-left"></i></a>
        <h1 class="text-2xl font-bold text-slate-800">Detail Poli</h1>
    </div>
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <dl class="space-y-4">
            <div><dt class="text-sm text-slate-500">Nama Poli</dt><dd class="mt-1 font-semibold text-slate-800">{{ $poli->nama_poli }}</dd></div>
            <div><dt class="text-sm text-slate-500">Keterangan</dt><dd class="mt-1 text-slate-800">{{ $poli->keterangan ?: '—' }}</dd></div>
        </dl>
        <a href="{{ route('polis.edit', $poli) }}" class="btn mt-6 border-0 bg-amber-500 text-white hover:bg-amber-600">Edit Poli</a>
    </div>
</x-layouts.app>
