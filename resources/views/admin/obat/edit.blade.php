<x-layouts.app title="Edit Obat">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('obat.index') }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200"><i class="fas fa-arrow-left"></i></a>
        <h1 class="text-2xl font-bold text-slate-800">Edit Obat</h1>
    </div>

    <form action="{{ route('obat.update', $obat) }}" method="POST" class="card rounded-2xl border border-slate-200 bg-base-100 shadow-md">
        @csrf
        @method('PUT')
        <div class="card-body space-y-5 p-7">
            <div>
                <label for="nama_obat" class="mb-1 block text-sm font-semibold">Nama Obat *</label>
                <input id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}" required class="input input-bordered w-full">
                @error('nama_obat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="kemasan" class="mb-1 block text-sm font-semibold">Kemasan</label>
                <input id="kemasan" name="kemasan" value="{{ old('kemasan', $obat->kemasan) }}" maxlength="35" class="input input-bordered w-full">
                @error('kemasan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="harga" class="mb-1 block text-sm font-semibold">Harga (Rp) *</label>
                <input id="harga" type="number" name="harga" value="{{ old('harga', $obat->harga) }}" min="0" step="1" required class="input input-bordered w-full">
                @error('harga') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn border-0 bg-[#4338ca] text-white hover:bg-[#3730a3]">Simpan Perubahan</button>
                <a href="{{ route('obat.index') }}" class="btn border-0 bg-slate-100 text-slate-600 hover:bg-slate-200">Batal</a>
            </div>
        </div>
    </form>
</x-layouts.app>
