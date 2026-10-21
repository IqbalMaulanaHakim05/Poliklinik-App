<x-layouts.app title="Tambah Dokter">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('dokter.index') }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition hover:bg-slate-200">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Tambah Dokter</h2>
    </div>

    <div class="card rounded-2xl border border-slate-200 bg-base-100 shadow-md">
        <div class="card-body p-8">
            <form action="{{ route('dokter.store') }}" method="POST">
                @csrf
                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="form-control">
                        <label for="nama" class="label"><span class="label-text text-sm font-semibold text-slate-700">Nama Dokter <span class="text-red-500">*</span></span></label>
                        <input id="nama" type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama dokter..." class="input input-bordered w-full rounded-lg border-2 p-2 focus:outline-none focus:ring-2 focus:ring-primary @error('nama') input-error @enderror" required>
                        @error('nama') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label for="email" class="label"><span class="label-text text-sm font-semibold text-slate-700">Email <span class="text-red-500">*</span></span></label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email..." class="input input-bordered w-full rounded-lg border-2 p-2 focus:ring-2 focus:ring-primary @error('email') input-error @enderror" required>
                        @error('email') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label for="no_ktp" class="label"><span class="label-text text-sm font-semibold text-slate-700">No. KTP <span class="text-red-500">*</span></span></label>
                        <input id="no_ktp" type="text" inputmode="numeric" pattern="[0-9]*" name="no_ktp" value="{{ old('no_ktp') }}" maxlength="16" placeholder="Masukkan No. KTP..." class="input input-bordered w-full rounded-lg border-2 p-2 focus:ring-2 focus:ring-primary @error('no_ktp') input-error @enderror" required>
                        @error('no_ktp') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label for="no_hp" class="label"><span class="label-text text-sm font-semibold text-slate-700">No. HP <span class="text-red-500">*</span></span></label>
                        <input id="no_hp" type="text" inputmode="numeric" pattern="[0-9]*" name="no_hp" value="{{ old('no_hp') }}" maxlength="15" placeholder="Masukkan No. HP..." class="input input-bordered w-full rounded-lg border-2 p-2 focus:ring-2 focus:ring-primary @error('no_hp') input-error @enderror" required>
                        @error('no_hp') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-control mb-6">
                    <label for="alamat" class="label"><span class="label-text text-sm font-semibold text-slate-700">Alamat <span class="text-red-500">*</span></span></label>
                    <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat..." class="textarea textarea-bordered w-full rounded-lg border-2 p-2 focus:ring-2 focus:ring-primary @error('alamat') textarea-error @enderror" required>{{ old('alamat') }}</textarea>
                    @error('alamat') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="form-control mb-6">
                    <label for="id_poli" class="label"><span class="label-text text-sm font-semibold text-slate-700">Poli <span class="text-red-500">*</span></span></label>
                    <select id="id_poli" name="id_poli" class="select select-bordered w-full rounded-lg border-2 p-2 focus:ring-2 focus:ring-primary @error('id_poli') select-error @enderror" required>
                        <option value="">Pilih Poli</option>
                        @foreach ($polis as $poli)
                            <option value="{{ $poli->id }}" @selected(old('id_poli') == $poli->id)>{{ $poli->nama_poli }}</option>
                        @endforeach
                    </select>
                    @error('id_poli') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="form-control mb-8">
                    <label for="password" class="label"><span class="label-text text-sm font-semibold text-slate-700">Password <span class="text-red-500">*</span></span></label>
                    <input id="password" type="password" name="password" minlength="8" placeholder="Minimal 8 karakter..." class="input input-bordered w-full rounded-lg border-2 p-2 focus:ring-2 focus:ring-primary @error('password') input-error @enderror" required>
                    @error('password') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg border-2 bg-primary px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90"><i class="fas fa-save text-sm"></i> Simpan</button>
                    <a href="{{ route('dokter.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-6 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-200">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
