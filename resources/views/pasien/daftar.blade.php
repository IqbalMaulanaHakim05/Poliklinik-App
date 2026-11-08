<x-layouts.app title="Daftar Poli">

    <div class="flex items-center justify-center px-4">
        <div class="w-full max-w-3xl">
            <div class="card rounded-lg border border-slate-100 bg-white shadow-sm">
                <div class="card-body p-6">

                    <h2 class="text-2xl font-bold text-center mb-6">
                        🏥 Pendaftaran Poli
                    </h2>

                    {{-- Toast Success --}}
                    @if (session('message'))
                    <div id="toastSuccess" class="toast toast-top toast-end z-50">
                        <div class="alert alert-success shadow-lg">
                            <span> {{ session('message') }}</span>
                        </div>
                    </div>
                    @endif

                    {{-- Error --}}
                    @if ($errors->any())
                    <div class="alert alert-error mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('pasien.daftar.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_pasien" value="{{ $user->id }}">

                        {{-- Nomor RM --}}
                        <div class="mb-4">
                            <label class="font-semibold block mb-1">
                                Nomor Rekam Medis
                            </label>

                            <input type="text" value="{{ $user->no_rm }}"
                                class="w-full border-2 rounded-lg p-2 bg-gray-100" disabled>
                        </div>

                        {{-- Pilih Poli --}}
                        <div class="mb-4">
                            <label class="font-semibold block mb-1">
                                Pilih Poli
                            </label>

                            <select name="id_poli" id="poliSelect" required class="w-full border border-slate-300 rounded-lg p-2">
                                <option value="">-- Pilih Poli --</option>
                                @foreach ($polis as $poli)
                                <option value="{{ $poli->id }}" @selected(old('id_poli') == $poli->id)>
                                    {{ $poli->nama_poli }}
                                </option>
                                @endforeach
                            </select>

                        </div>

                        {{-- Pilih Jadwal --}}
                        <div class="mb-4">
                            <label class="font-semibold block mb-1">
                                Pilih Jadwal Periksa
                            </label>

                            <select name="id_jadwal" id="jadwalSelect" required class="w-full border border-slate-300 rounded-lg p-2">
                                <option value="">-- Pilih Jadwal --</option>

                                @foreach ($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}" data-poli="{{ $jadwal->dokter?->id_poli }}" @selected(old('id_jadwal') == $jadwal->id)>
                                    {{ $jadwal->hari }}
                                    {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                    Dr. {{ $jadwal->dokter->nama ?? '--' }}
                                </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- Keluhan --}}
                        <div class="mb-6">
                            <label class="font-semibold block mb-1">
                                Keluhan
                            </label>
                            <textarea name="keluhan" rows="3" class="w-full border border-slate-300 rounded-lg p-2"
                                placeholder="Tulis keluhan anda...">{{ old('keluhan') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-8 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                Daftar Poli
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function(){

    const poliSelect = document.getElementById("poliSelect")
    const jadwalSelect = document.getElementById("jadwalSelect")
    const jadwalOptions = jadwalSelect.querySelectorAll("option")

    function filterJadwal() {
        const selected = jadwalSelect.value
        jadwalSelect.replaceChildren(...Array.from(jadwalOptions)
            .filter(option => option.value === "" || option.dataset.poli === poliSelect.value))
        jadwalSelect.value = Array.from(jadwalSelect.options).some(option => option.value === selected) ? selected : ""
    }
    poliSelect.addEventListener("change", filterJadwal)
    filterJadwal()
        })
    </script>
    @endpush
</x-layouts.app>
