<x-layouts.app title="Data Pasien">

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800">Data Pasien</h2>

        <a href="{{ route('pasien.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">
            <i class="fas fa-plus text-xs"></i>
            Tambah Pasien
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-4 rounded-xl shadow-sm">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Card --}}
    <div class="card rounded-2 border bg-base-100 shadow-md">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    {{-- Table Head --}}
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Nama Pasien</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">No. KTP</th>
                            <th class="px-6 py-4">No. HP</th>
                            <th class="px-6 py-4">Alamat</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="text-sm text-slate-700">
                        @forelse ($pasiens as $pasien)
                            <tr class="border-t border-slate-100 transition hover:bg-slate-50">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $pasien->nama }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $pasien->email }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $pasien->no_ktp ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $pasien->no_hp ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $pasien->alamat ?? '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('pasien.edit', $pasien->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-amber-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-amber-600">
                                            <i class="fas fa-pen text-xs"></i> Edit
                                        </a>
                                        <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pasien ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-red-600">
                                                <i class="fas fa-trash text-xs"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    <i class="fas fa-inbox mb-3 block text-3xl"></i>
                                    Belum ada data pasien
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
