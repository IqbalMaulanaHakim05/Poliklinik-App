<x-layouts.app title="Data Dokter">

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800">Data Dokter</h2>

        <a href="{{ route('dokter.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">
            <i class="fas fa-plus text-sm"></i>
            Tambah Dokter
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-4 rounded-xl shadow-sm">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Card Table --}}
    <div class="card rounded-2 border bg-base-100 shadow-md">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-slate-100 text-xs uppercase tracking-wider text-slate-600">
                        <tr>
                            <th class="px-6 py-4">Nama Dokter</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">No. KTP</th>
                            <th class="px-6 py-4">No. HP</th>
                            <th class="px-6 py-4">Alamat</th>
                            <th class="px-6 py-4">Poli</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-700">
                        @forelse ($dokters as $dokter)
                            <tr class="border-b border-slate-100 transition hover:bg-slate-50">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $dokter->nama }}</td>
                                <td class="px-6 py-4">{{ $dokter->email }}</td>
                                <td class="px-6 py-4">{{ $dokter->no_ktp ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $dokter->no_hp ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $dokter->alamat ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                        {{ $dokter->poli?->nama_poli ?? 'Belum Dipilih' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('dokter.edit', $dokter->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-amber-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-amber-600">
                                            <i class="fas fa-pen-to-square text-xs"></i> Edit
                                        </a>
                                        <form action="{{ route('dokter.destroy', $dokter->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dokter ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-600">
                                                <i class="fas fa-trash text-xs"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center text-slate-400">
                                    <i class="fas fa-inbox mb-3 block text-3xl"></i>
                                    Belum ada data dokter
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
