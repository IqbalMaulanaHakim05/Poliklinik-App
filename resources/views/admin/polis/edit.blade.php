<x-layouts.app title="Edit Poli">

    {{-- Header --}}
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('polis.index') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500 transition hover:bg-slate-200">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>

        <h2 class="text-2xl font-bold text-slate-800">Edit Poli</h2>
    </div>

    {{-- Card --}}
    <div class="card rounded-2xl border border-slate-200 bg-base-100 shadow-md">
        <div class="card-body p-8">
            <form action="{{ route('polis.update', $poli->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Poli --}}
                <div class="mb-6">
                    <label for="nama_poli" class="mb-1 block text-sm font-semibold text-slate-700">
                        Nama Poli <span class="text-red-500">*</span>
                    </label>

                    <input id="nama_poli" type="text" name="nama_poli" value="{{ old('nama_poli', $poli->nama_poli) }}"
                        placeholder="Masukkan nama poli..."
                        class="w-full rounded-lg border-2 border-slate-300 px-4 py-2 focus:border-primary focus:outline-none @error('nama_poli') border-red-500 @enderror"
                        required>

                    @error('nama_poli')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="mb-8">
                    <label for="keterangan" class="mb-1 block text-sm font-semibold text-slate-700">
                        Keterangan <span class="text-red-500">*</span>
                    </label>

                    <textarea id="keterangan" name="keterangan" rows="4" placeholder="Masukkan keterangan poli..."
                        class="w-full rounded-lg border-2 border-slate-300 px-4 py-2 focus:border-primary focus:outline-none @error('keterangan') border-red-500 @enderror"
                        required>{{ old('keterangan', $poli->keterangan) }}</textarea>

                    @error('keterangan')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Button --}}
                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-primary px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>

                    <a href="{{ route('polis.index') }}" class="rounded-lg bg-slate-100 px-6 py-2.5 font-semibold text-slate-600 transition hover:bg-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
