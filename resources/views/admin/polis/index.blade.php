<x-layouts.app title="Data Poli">

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800">Data Poli</h2>

        <a href="{{ route('polis.create') }}" class="btn rounded-lg border-none bg-[#2d4499] px-5 text-white hover:bg-[#1e2d6b]">
            <i class="fas fa-plus"></i>
            Tambah Poli
        </a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success mb-4 rounded-xl shadow-sm">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error mb-4 rounded-xl shadow-sm">
            <i class="fas fa-circle-xmark"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Card --}}
    <div class="card rounded-2 border bg-base-100 shadow-md">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead class="bg-slate-100 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Nama Poli</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($polis as $poli)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $poli->nama_poli }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $poli->keterangan ?: '—' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('polis.edit', $poli->id) }}" class="btn btn-sm rounded-lg border-none bg-amber-500 px-4 text-white hover:bg-amber-600">
                                            <i class="fas fa-pen-to-square"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('polis.destroy', $poli->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus poli ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm rounded-lg border-none bg-red-500 px-4 text-white hover:bg-red-600">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-14 text-center text-slate-400">
                                    <i class="fas fa-inbox mb-3 block text-3xl"></i>
                                    Belum ada data poli
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
