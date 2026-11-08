<x-layouts.app title="Periksa Pasien">
    <h1 class="mb-6 text-xl font-bold text-slate-800">Periksa Pasien</h1>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm">
        <table class="table w-full">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500"><tr><th>ID</th><th>Pasien</th><th>Keluhan</th><th>No Antrian</th><th class="text-right">Aksi</th></tr></thead>
            <tbody class="text-sm text-slate-600">
                @forelse ($daftarPasien as $pendaftaran)
                    <tr class="border-b border-slate-100 even:bg-slate-50 last:border-b-0">
                        <td>{{ $pendaftaran->id }}</td>
                        <td class="font-semibold text-slate-800">{{ $pendaftaran->pasien?->nama ?? '-' }}</td>
                        <td>{{ $pendaftaran->keluhan ?: '-' }}</td>
                        <td>{{ $pendaftaran->no_antrian }}</td>
                        <td class="text-right">
                            @if ($pendaftaran->periksas->isNotEmpty())
                                <span class="inline-flex items-center gap-2 rounded-lg bg-green-100 px-3 py-1.5 text-xs font-semibold text-green-700"><i class="fas fa-circle-check" aria-hidden="true"></i> Sudah Diperiksa</span>
                            @else
                                <a class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2 text-xs font-semibold text-white hover:bg-amber-600" href="{{ route('periksa-pasien.create', $pendaftaran->id) }}"><i class="fas fa-stethoscope" aria-hidden="true"></i> Periksa</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-10 text-center text-slate-500">Belum ada pasien terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
