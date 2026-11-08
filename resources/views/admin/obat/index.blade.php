<x-layouts.app title="Data Obat">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-slate-800">Data Obat</h1>
        <a href="{{ route('obat.create') }}" class="btn rounded-lg border-none bg-[#2d4499] px-5 text-white hover:bg-[#1e2d6b]"><i class="fas fa-plus" aria-hidden="true"></i> Tambah Obat</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-4 rounded-xl shadow-sm"><i class="fas fa-circle-check"></i><span>{{ session('success') }}</span></div>
    @endif

    <div class="card rounded-2 border bg-base-100 shadow-md">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
        <table class="table w-full border-collapse">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr><th class="border-b border-slate-100 px-6 py-4">Nama Obat</th><th class="border-b border-slate-100 px-6 py-4">Kemasan</th><th class="border-b border-slate-100 px-6 py-4">Harga</th><th class="border-b border-slate-100 px-6 py-4 text-right">Aksi</th></tr>
            </thead>
            <tbody class="text-sm text-slate-700">
                @forelse ($obats as $obat)
                    <tr class="border-b border-slate-100 transition even:bg-slate-50 last:border-b-0 hover:bg-slate-50">
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $obat->nama_obat }}</td>
                        <td class="px-6 py-4">{{ $obat->kemasan ?: '—' }}</td>
                        <td class="whitespace-nowrap px-6 py-4">Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('obat.edit', $obat) }}" class="inline-flex items-center gap-1 rounded-lg bg-amber-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-amber-600"><i class="fas fa-pen text-xs" aria-hidden="true"></i> Edit</a>
                                <form action="{{ route('obat.destroy', $obat) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus obat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex cursor-pointer items-center gap-1 rounded-lg bg-red-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-red-600"><i class="fas fa-trash text-xs" aria-hidden="true"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-14 text-center text-slate-400"><i class="fas fa-inbox mb-3 block text-3xl"></i>Belum ada data obat</td></tr>
                @endforelse
            </tbody>
        </table>
            </div>
        </div>
    </div>
</x-layouts.app>
