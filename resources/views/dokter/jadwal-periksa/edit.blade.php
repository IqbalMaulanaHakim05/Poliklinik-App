<x-layouts.app title="Edit Jadwal Periksa">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('jadwal-periksa.index') }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200"><i class="fas fa-arrow-left"></i></a>
        <h1 class="text-2xl font-bold text-slate-800">Edit Jadwal Periksa</h1>
    </div>

    <form action="{{ route('jadwal-periksa.update', $jadwal->id) }}" method="POST" class="card rounded-2xl border border-slate-200 bg-base-100 shadow-md">
        @csrf
        @method('PUT')
        <div class="card-body space-y-5 p-7">
            <div>
                <label for="hari" class="mb-1 block text-sm font-semibold">Hari *</label>
                <select id="hari" name="hari" required class="select select-bordered w-full">
                    @foreach ($hariOptions as $hari)
                        <option value="{{ $hari }}" @selected(old('hari', $jadwal->hari) === $hari)>{{ $hari }}</option>
                    @endforeach
                </select>
                @error('hari') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="jam_mulai" class="mb-1 block text-sm font-semibold">Jam Mulai *</label>
                <input id="jam_mulai" type="time" name="jam_mulai" value="{{ old('jam_mulai', substr($jadwal->jam_mulai, 0, 5)) }}" required class="input input-bordered w-full">
                @error('jam_mulai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="jam_selesai" class="mb-1 block text-sm font-semibold">Jam Selesai *</label>
                <input id="jam_selesai" type="time" name="jam_selesai" value="{{ old('jam_selesai', substr($jadwal->jam_selesai, 0, 5)) }}" required class="input input-bordered w-full">
                @error('jam_selesai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn border-0 bg-[#4338ca] text-white hover:bg-[#3730a3]">Simpan Perubahan</button>
                <a href="{{ route('jadwal-periksa.index') }}" class="btn border-0 bg-slate-100 text-slate-600 hover:bg-slate-200">Batal</a>
            </div>
        </div>
    </form>
</x-layouts.app>
