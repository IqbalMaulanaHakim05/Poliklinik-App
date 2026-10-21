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

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="table w-full">
            <thead class="bg-slate-100 text-xs uppercase tracking-wider text-slate-600">
                <tr><th>Hari</th><th>Jam Mulai</th><th>Jam Selesai</th><th>Status</th><th class="text-right">Aksi</th></tr>
            </thead>
            <tbody class="text-sm text-slate-700">
                @forelse ($jadwals as $jadwal)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="font-semibold text-slate-800">{{ $jadwal->hari }}</td>
                        <td>{{ substr($jadwal->jam_mulai, 0, 5) }}</td>
                        <td>{{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                        <td><span class="badge border-0 bg-emerald-100 text-emerald-700">Aktif</span></td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('jadwal-periksa.edit', $jadwal->id) }}" class="btn btn-sm border-0 bg-amber-500 text-white hover:bg-amber-600">Edit</a>
                                <form action="{{ route('jadwal-periksa.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm border-0 bg-red-500 text-white hover:bg-red-600">Hapus</button>
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
</x-layouts.app>
