<x-layouts.app title="Riwayat Pasien">
    <h1 class="mb-6 text-xl font-bold text-slate-800">Riwayat Pasien</h1>
    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm">
        <table class="table w-full">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr><th>ID</th><th>Pasien</th><th>Keluhan</th><th>Tanggal Periksa</th><th class="text-right">Aksi</th></tr>
            </thead>
            <tbody class="text-sm text-slate-600">
                @forelse ($riwayats as $periksa)
                    <tr class="border-b border-slate-100 even:bg-slate-50 last:border-b-0">
                        <td>{{ $periksa->id }}</td>
                        <td class="font-semibold text-slate-800">{{ $periksa->daftarPoli->pasien->nama }}</td>
                        <td>{{ $periksa->daftarPoli->keluhan ?: '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d/m/Y H:i') }}</td>
                        <td class="text-right"><a href="{{ route('riwayat-pasien.show', $periksa->id) }}" class="inline-flex items-center gap-2 rounded-lg bg-[#2d4499] px-4 py-2 text-xs font-semibold text-white hover:bg-[#1e2d6b]"><i class="fas fa-eye" aria-hidden="true"></i> Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-10 text-center text-slate-500">Belum ada riwayat pemeriksaan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $riwayats->links() }}</div>
</x-layouts.app>
