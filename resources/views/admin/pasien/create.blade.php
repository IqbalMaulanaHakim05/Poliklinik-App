<x-layouts.app title="Tambah Pasien">

    {{-- Header --}}
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('pasien.index') }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition hover:bg-slate-200">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Tambah Pasien</h2>
    </div>

    {{-- Card --}}
    <div class="card rounded-2xl border border-slate-200 bg-base-100 shadow-md">
        <div class="card-body p-8">
            <form action="{{ route('pasien.store') }}" method="POST">
                @csrf

                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="nama" class="mb-1 block text-sm font-semibold text-slate-700">Nama Pasien <span class="text-red-500">*</span></label>
                        <input id="nama" type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama pasien..." class="w-full rounded-lg border-2 p-2 focus:border-primary focus:outline-none @error('nama') border-red-500 @enderror" required>
                        @error('nama') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-sm font-semibold text-slate-700">Email <span class="text-red-500">*</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email..." class="w-full rounded-lg border-2 p-2 focus:border-primary focus:outline-none @error('email') border-red-500 @enderror" required>
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="no_ktp" class="mb-1 block text-sm font-semibold text-slate-700">No. KTP <span class="text-red-500">*</span></label>
                        <input id="no_ktp" type="text" inputmode="numeric" pattern="[0-9]*" name="no_ktp" value="{{ old('no_ktp') }}" maxlength="16" placeholder="Masukkan No. KTP..." class="w-full rounded-lg border-2 p-2 focus:border-primary focus:outline-none @error('no_ktp') border-red-500 @enderror" required>
                        @error('no_ktp') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="mb-1 block text-sm font-semibold text-slate-700">No. HP <span class="text-red-500">*</span></label>
                        <input id="no_hp" type="text" inputmode="numeric" pattern="[0-9]*" name="no_hp" value="{{ old('no_hp') }}" maxlength="15" placeholder="Masukkan No. HP..." class="w-full rounded-lg border-2 p-2 focus:border-primary focus:outline-none @error('no_hp') border-red-500 @enderror" required>
                        @error('no_hp') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="alamat" class="mb-1 block text-sm font-semibold text-slate-700">Alamat <span class="text-red-500">*</span></label>
                    <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat..." class="w-full rounded-lg border-2 p-2 focus:border-primary focus:outline-none @error('alamat') border-red-500 @enderror" required>{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mb-8">
                    <label for="password" class="mb-1 block text-sm font-semibold text-slate-700">Password <span class="text-red-500">*</span></label>
                    <input id="password" type="password" name="password" minlength="8" placeholder="Minimal 8 karakter..." class="w-full rounded-lg border-2 p-2 focus:border-primary focus:outline-none @error('password') border-red-500 @enderror" required>
                    @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="rounded-xl bg-primary px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90"><i class="fas fa-save mr-1"></i> Simpan</button>
                    <a href="{{ route('pasien.index') }}" class="rounded-xl bg-slate-100 px-6 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-200">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
