<x-layouts.app title="Periksa Pasien">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('periksa-pasien.index') }}" class="inline-flex items-center justify-center w-9 h-9
                  rounded-lg bg-slate-100 text-slate-500
                  hover:bg-slate-200 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">
            Periksa Pasien
        </h2>
    </div>

    {{-- Card --}}
    <div class="card bg-base-100 shadow-sm rounded-2xl border border-slate-200">
        <div class="card-body p-8">

            <form action="{{ route('periksa-pasien.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_daftar_poli" value="{{ $id }}">

                @if ($errors->any())
                    <div class="alert alert-error mb-5"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif

                {{-- Pilih Obat --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Pilih Obat <span class="text-red-500">*</span></span>
                    </label>
                    <select id="select-obat" class="select select-bordered w-full rounded-lg border-2 px-4">
                        <option value="">-- Pilih Obat --</option>
                        @foreach ($obats as $obat)
                            <option value="{{ $obat->id }}"
                                data-nama="{{ $obat->nama_obat }}"
                                data-harga="{{ $obat->harga }}">
                                {{ $obat->nama_obat }} - Rp{{ number_format($obat->harga) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Obat Terpilih --}}
                <div class="form-control mb-5">
                    <label class="label pb-1 ">
                        <span class="text-sm font-semibold text-gray-700">Obat Terpilih</span>
                    </label>

                    <ul id="obat-terpilih" class="flex flex-col gap-2 mb-2 min-h-[48px]"></ul>

                    <div id="obat-inputs"></div>
                </div>

                {{-- Total Harga --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Total Harga</span>
                    </label>
                    <div class="input input-bordered w-full rounded-lg flex items-center bg-slate-50 text-slate-700 font-bold" id="total-harga">
                        Rp 0
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="form-control mb-8">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Catatan <span class="text-slate-400 font-normal">(Opsional)</span></span>
                    </label>
                    <textarea name="catatan" id="catatan" rows="4"
                        placeholder="Masukkan catatan..."
                        class="textarea textarea-bordered w-full border-2 px-4 py-2 rounded-lg resize-none">{{ old('catatan') }}</textarea>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="btn bg-[#2d4499] hover:bg-[#1e2d6b] text-white border-none rounded-lg px-6">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                    <a href="{{ route('periksa-pasien.index') }}"
                        class="btn btn-ghost bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg px-6">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script>
        const selectObat = document.getElementById('select-obat');
        const listObat = document.getElementById('obat-terpilih');
        const obatInputs = document.getElementById('obat-inputs');
        const totalHargaEl = document.getElementById('total-harga');

        const previousIds = @json(old('obat_ids', []));
        let daftarObat = Array.from(selectObat.options)
            .filter(option => option.value && previousIds.map(String).includes(option.value))
            .map(option => ({ id: option.value, nama: option.dataset.nama, harga: Number(option.dataset.harga) }));

        selectObat.addEventListener('change', () => {
            const selectedOption = selectObat.options[selectObat.selectedIndex];
            const id = selectedOption.value;
            const nama = selectedOption.dataset.nama;
            const harga = parseInt(selectedOption.dataset.harga || 0);

            if (!id || daftarObat.some(o => o.id == id)) return;

            daftarObat.push({ id, nama, harga });
            renderObat();
            selectObat.selectedIndex = 0;
        });

        function renderObat() {
            listObat.innerHTML = '';
            obatInputs.replaceChildren();
            let total = 0;

            daftarObat.forEach((obat, index) => {
                total += obat.harga;

                const item = document.createElement('li');
                item.className = 'flex items-center justify-between px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700';
                const label = document.createElement('span');
                label.textContent = `${obat.nama} — Rp ${obat.harga.toLocaleString('id-ID')}`;
                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'btn btn-sm bg-red-500 hover:bg-red-600 text-white border-none rounded-lg px-3';
                remove.textContent = 'Hapus';
                remove.setAttribute('aria-label', `Hapus ${obat.nama}`);
                remove.addEventListener('click', () => hapusObat(index));
                item.append(label, remove);
                listObat.appendChild(item);
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'obat_ids[]';
                input.value = obat.id;
                obatInputs.appendChild(input);
            });

            totalHargaEl.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        function hapusObat(index) {
            daftarObat.splice(index, 1);
            renderObat();
        }
        renderObat();
    </script>

</x-layouts.app>
