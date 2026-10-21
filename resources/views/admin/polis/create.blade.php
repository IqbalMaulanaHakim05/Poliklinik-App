<x-layouts.app title="Tambah Poli">

    {{-- Header --}}
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('polis.index') }}"
            class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500 transition hover:bg-slate-200">
            <i class="fas fa-arrow-left text-xs"></i>
        </a>
        <h2 class="text-xl font-bold text-slate-800">Tambah Poli</h2>
    </div>

    {{-- Card --}}
    <div class="card rounded-2xl border border-slate-200 bg-base-100 shadow-md">
        <div class="card-body p-7">
            <form action="{{ route('polis.store') }}" method="POST">
                @csrf

                {{-- Nama Poli --}}
                <div class="form-control mb-5">
                    <label class="label pb-1" for="nama_poli">
                        <span class="text-sm font-semibold text-gray-700">Nama Poli <span class="text-red-500">*</span></span>
                    </label>
                    <input id="nama_poli" type="text" name="nama_poli" value="{{ old('nama_poli') }}"
                        placeholder="Masukkan nama poli..." maxlength="25"
                        class="input input-bordered w-full rounded-lg text-sm @error('nama_poli') input-error @enderror"
                        required>
                    @error('nama_poli')
                        <label class="label pt-1"><span class="label-text-alt text-red-500">{{ $message }}</span></label>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="form-control mb-6">
                    <label class="label pb-1" for="keterangan">
                        <span class="text-sm font-semibold text-gray-700">Keterangan <span class="text-red-500">*</span></span>
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="4" placeholder="Masukkan keterangan poli..."
                        class="textarea textarea-bordered w-full resize-none rounded-lg text-sm @error('keterangan') textarea-error @enderror"
                        required>{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <label class="label pt-1"><span class="label-text-alt text-red-500">{{ $message }}</span></label>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex items-center gap-2 rounded-lg bg-[#2d4499] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#1e2d6b]">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                    <a href="{{ route('polis.index') }}"
                        class="flex items-center gap-2 rounded-lg bg-slate-100 px-6 py-2.5 text-sm font-semibold text-slate-500 transition hover:bg-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
