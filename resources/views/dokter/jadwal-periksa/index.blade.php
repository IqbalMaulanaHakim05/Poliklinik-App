<x-layouts.app title="Jadwal Periksa">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Jadwal Periksa</h1>
            <p class="mt-1 text-sm text-slate-500">Atur jadwal praktik yang tersedia untuk pasien.</p>
        </div>
        <a href="{{ route('jadwal-periksa.create') }}" class="btn border-0 bg-[#4338ca] text-white hover:bg-[#3730a3]"><i class="fas fa-plus"></i> Tambah Jadwal</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-4 rounded-xl shadow-sm"><i class="fas fa-circle-check"></i><span>{{ session('success') }}</span></div>
    @endif

    <div class="card rounded-2 border bg-base-100 shadow-md">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
        <table class="table w-full">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr><th class="px-6 py-4">ID</th><th class="px-6 py-4">Hari</th><th class="px-6 py-4">Jam Mulai</th><th class="px-6 py-4">Jam Selesai</th><th class="px-6 py-4 text-right">Aksi</th></tr>
            </thead>
            <tbody class="text-sm text-slate-700">
                @forelse ($jadwals as $jadwal)
                    <tr class="border-b border-slate-100 transition even:bg-slate-50 last:border-b-0 hover:bg-slate-50">
                        <td class="px-6 py-4">{{ $jadwal->id }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $jadwal->hari }}</td>
                        <td class="px-6 py-4">{{ substr($jadwal->jam_mulai, 0, 5) }}</td>
                        <td class="px-6 py-4">{{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('jadwal-periksa.edit', $jadwal->id) }}" class="inline-flex items-center gap-1 rounded-lg bg-amber-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-amber-600"><i class="fas fa-pen text-xs" aria-hidden="true"></i> Edit</a>
                                <form action="{{ route('jadwal-periksa.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex cursor-pointer items-center gap-1 rounded-lg bg-red-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-red-600"><i class="fas fa-trash text-xs" aria-hidden="true"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-14 text-center text-slate-400"><i class="fas fa-calendar-xmark mb-3 block text-3xl"></i>Belum ada jadwal periksa.</td></tr>
                @endforelse
            </tbody>
        </table>
            </div>
        </div>
    </div>
</x-layouts.app>
