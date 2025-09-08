<!-- Jabatan create -->
<div class="view mt-1">
    @php
        use Carbon\Carbon;

        if (!function_exists('uiDate')) {
            function uiDate($value) {
                if (empty($value)) return '';
                try {
                    // Kalau dari DB (Y-m-d) → ke d-m-Y
                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                        return Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y');
                    }
                    // Kalau sudah d-m-Y (old input), biarin
                    if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
                        return $value;
                    }
                    // Fallback: coba parse bebas
                    return Carbon::parse($value)->format('d-m-Y');
                } catch (\Exception $e) {
                    return $value; // jangan bikin form blank kalau gagal parse
                }
            }
        }
    @endphp

    {{-- Periksa apakah sedang dalam mode edit atau create --}}
    @isset($jabatan) {{-- Jika variabel $jabatan ada, berarti mode edit --}}
        <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST">
        @method('PUT')
    @else {{-- Jika tidak ada variabel $jabatan, berarti mode create --}}
        <form action="{{ route('jabatan.store') }}" method="POST">
    @endisset
        @csrf
        <input type="hidden" name="pegawai_id" value="{{ $pegawai->id ?? '' }}">
        <div class="row mb-3">
            <label for="skpd" class="col-md-4 col-lg-3 col-form-label">SKPD</label>
            <div class="col-md-8 col-lg-9">
                <input name="skpd" type="text" class="form-control @error('skpd') is-invalid @enderror" id="skpd" value="{{ $jabatan->skpd ?? 'RSUD dr. Soeselo Slawi' }}" readonly>
                @error('skpd')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="unit_kerja" class="col-md-4 col-lg-3 col-form-label">Unit Kerja</label>
            <div class="col-md-4 col-lg-9">
                <select class="form-select" aria-label="Default select example" name="unit_kerja" id="unit_kerja" required>
                    <option value="" selected disabled>RSUD dr Soeselo Slawi</option>
                    @php
                        $unitKerjaOptions = [
                            'RSUD Dr. Soeselo Slawi', 'Direktur Pelayanan', 'Direktur Umum dan Keuangan',
                            'Bidang Pelayanan Medis', 'Bidang Pelayanan Keperawatan', 'Bidang Pelayanan Penunjang',
                            'Bagian Tata Usaha', 'Bagian Keuangan', 'Bagian Perencanaan',
                            'Sub Bagian Umum', 'Subbagian Kepegawaian'
                        ];
                    @endphp
                    @foreach ($unitKerjaOptions as $option)
                        <option value="{{ $option }}" {{ old('unit_kerja', $jabatan->unit_kerja ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
                @error('unit_kerja')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="nama_jabatan" class="col-md-4 col-lg-3 col-form-label">Jabatan</label>
            <div class="col-md-4 col-lg-9">
                <select class="form-select" aria-label="Default select example" name="nama_jabatan" id="nama_jabatan" required>
                    <option value="" selected disabled>-- Pilihan --</option>
                    @php
                        $namaJabatanOptions = [
                            'Direktur RSUD dr Soeselo', 'Wakil Direktur Pelayanan', 'Kepala Bidang Pelayanan Medis',
                            'Dokter Ahli Utama', 'Dokter Ahli Madya', 'Dokter Ahli Muda', 'Dokter Ahli Pertama',
                            'Dokter Gigi Ahli Madya', 'Penata Kelola Layanan Kesehatan', 'Pengadministrasi Perkantoran',
                            'Kepala Bidang Pelayanan Keperawatan', 'Perawat Ahli Madya', 'Perawat Ahli Muda',
                            'Perawat Ahli Pertama', 'Perawat Penyelia', 'Perawat Mahir', 'Perawat Terampil',
                            'Perawat Keahlian', 'Perawat Ketrampilan', 'Terapis Gigi dan Mulut Mahir',
                            'Terapis Gigi dan Mulut Terampil', 'Bidan Ahli Madya', 'Bidan Ahli Muda',
                            'Bidan Ahli Pertama', 'Bidan Penyelia', 'Bidan Mahir', 'Bidan Terampil',
                            'Penata Kelola Layanan Kesehatan ', 'Pengelola Layanan Kesehatan', 'Pengadministrasi Perkantoran ',
                            'Operator Layanan Operasional ', 'Kepala Bidang Pelayanan Penunjang', 'Administrator Kesehatan Ahli Muda',
                            'Administrator Kesehatan Ahli Pertama', 'Apoteker Ahli Utama ', 'Apoteker Ahli Madya',
                            'Apoteker Ahli Pertama', 'Asisten Apoteker Penyelia', 'Asisten Apoteker Terampil',
                            'Nutrisionis Ahli Madya', 'Nutrisionis Ahli Pertama ', 'Nutrisionis Penyelia',
                            'Radiografer Ahli Madya ', 'Radiografer Ahli Muda ', 'Radiografer Ahli Pertama ',
                            'Radiografer Penyelia ', 'Radiografer Terampil ', 'Pranata Laboratorium Kesehatan Ahli Madya',
                            'Pranata Laboratorium Kesehatan Ahli Muda', 'Pranata Laboratorium Kesehatan Penyelia',
                            'Pranata Laboratorium Kesehatan Mahir', 'Pranata Laboratorium Kesehatan Terampil',
                            'Fisioterapis Ahli Madya', 'Fisioterapis Ahli Muda', 'Fisioterapis Ahli Pertama',
                            'Fisioterapis Penyelia', 'Fisioterapis Terampil', 'Refraksionis Optisien Penyelia',
                            'Refraksionis Optisien Mahir', 'Perekam Medis Penyelia', 'Perekam Medis Mahir',
                            'Perekam Medis Terampil', 'Okupasi Terapis Mahir', 'Okupasi Terapis Terampil',
                            'Penata Anestesi Ahli Madya', 'Penata Anestesi Ahli Muda', 'Penata Anestesi Ahli Pertama',
                            'Asisten Penata Anestesi Penyelia', 'Asisten Penata Anestesi Terampil',
                            'Psikolog Klinis Ahli Pertama', 'Tenaga Sanitasi Lingkungan Ahli Madya ',
                            'Tenaga Sanitasi Lingkungan Ahli Muda', 'Tenaga Sanitasi Lingkungan Ahli Pertama',
                            'Tenaga Sanitasi Lingkungan Terampil', 'Teknisi Elektromedis Ahli Pertama',
                            'Teknisi Elektromedis Penyelia', 'Teknisi Elektromedis Mahir', 'Teknisi Elektromedis Terampil',
                            'Fisikawan Medis Ahli Pertama', 'Pembimbing Kesehatan Kerja Ahli Pertama',
                            'Teknisi Transfusi Darah Terampil', 'Terapis Wicara Mahir', 'Terapis Wicara Terampil',
                            'Ortotis Prostetis Terampil', 'Penata Kelola Layanan Kesehatan',
                            'Pengelola Layanan Operasional', 'Operator Layanan Kesehatan', 'Pengadministrasi Perkantoran',
                            'Pengelola Umum Operasional', 'Wakil Direktur Umum dan Keuangan', 'Kepala Bagian Tata Usaha',
                            'Kepala Subbagian Umum', 'Pranata Komputer Ahli Pertama', 'Penyuluh Kesehatan Masyarakat Ahli Pertama',
                            'Pranata Komputer Terampil', 'Arsiparis Terampil', 'Penelaah Teknis Kebijakan',
                            'Penata Layanan Operasional', 'Pengelola Layanan Operasional', 'Pengolah Data dan Informasi',
                            'Dokumentalis Hukum', 'Pengadministrasi Perkantoran', 'Operator Layanan Operasiona',
                            'Kepala Subbagian Kepegawaian', 'Penata Layanan Operasional', 'Pengelola Layanan Operasional',
                            'Operator Layanan Operasional', 'Pengadministrasi Perkantoran', 'Kepala Bagian Keuangan',
                            'Analis Keuangan Pusat dan Daerah Ahli Muda', 'Analis Keuangan Pusat dan Daerah Ahli Pertama',
                            'Penelaah Teknis Kebijakan', 'Fasilitator Pemerintahan', 'Pengolah Data dan Informasi ',
                            'Operator Layanan Operasional ', 'Kepala Bagian Perencanaan', 'Perencana Ahli Pertama',
                            'Penelaah Teknis Kebijakan', 'Pengadministrasi Perkantoran'
                        ];
                    @endphp
                    @foreach ($namaJabatanOptions as $option)
                        <option value="{{ $option }}" {{ old('nama_jabatan', $jabatan->nama_jabatan ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="formasi_jabatan" class="col-md-4 col-lg-3 col-form-label">Formasi Jabatan</label>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="formasi_jabatan" id="formasi_jabatan">
                    <option value="" selected disabled>-- Pilihan --</option>
                    @php
                        $formasiJabatanOptions = [
                            'Dokter', 'Perawat', 'Terapis Gigi dan Mulut', 'Bidan', 'Administrator Kesehatan',
                            'Apoteker', 'Asisten Apoteker', 'Nutrisionis', 'Radiografer',
                            'Pranata Laboratorium Kesehatan', 'Fisioterapis', 'Refraksionis Optisien',
                            'Perekam Medis', 'Okupasi Terapis', 'Penata Anestesi', 'Asisten Penata Anestes',
                            'Psikolog Klinis', 'Tenaga Sanitasi Lingkungan', 'Teknisi Elektromedis',
                            'Fisikawan Medis', 'Pembimbing Kesehatan Kerja', 'Teknisi Transfusi Darah',
                            'Terapis Wicara', 'Ortotis Prostetis'
                        ];
                    @endphp
                    @foreach ($formasiJabatanOptions as $option)
                        <option value="{{ $option }}" {{ old('formasi_jabatan', $jabatan->formasi_jabatan ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
                @error('formasi_jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="formasi_jabatan_tingkat" id="formasi_jabatan_tingkat">
                    <option value="" selected disabled>-- Pilihan --</option>
                    @php
                        $tingkatOptions = ['Ahli Madya', 'Ahli Muda', 'Ahli Pertama', 'Penyelia', 'Mahir', 'Terampil'];
                    @endphp
                    @foreach ($tingkatOptions as $option)
                        <option value="{{ $option }}" {{ old('formasi_jabatan_tingkat', $jabatan->formasi_jabatan_tingkat ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
                @error('formasi_jabatan_tingkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="formasi_jabatan_keterangan" id="formasi_jabatan_keterangan">
                    <option value="" selected disabled>-- Pilihan --</option>
                    @php
                        $keteranganOptions = ['Umum', 'Spesialis', 'Sub Spesialis'];
                    @endphp
                    @foreach ($keteranganOptions as $option)
                        <option value="{{ $option }}" {{ old('formasi_jabatan_keterangan', $jabatan->formasi_jabatan_keterangan ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
                @error('formasi_jabatan_keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3 form-group">
            <label for="jenis_kepegawaian" class="col-md-4 col-lg-3 col-form-label">Jenis Kepegawaian</label>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="jenis_kepegawaian" id="jenis_kepegawaian" required>
                    <option value="" selected disabled>-- Pilihan --</option>
                    @php
                        $jenisKepegawaianOptions = ['PNS', 'PPPK', 'CPNS', 'BLUD', 'Mitra', 'Ahli Daya'];
                    @endphp
                    @foreach ($jenisKepegawaianOptions as $option)
                        <option value="{{ $option }}" {{ old('jenis_kepegawaian', $jabatan->jenis_kepegawaian ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            @error('jenis_kepegawaian')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3 form-group">
            <label for="jenis_jabatan" class="col-md-4 col-lg-3 col-form-label">Jenis Jabatan</label>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="jenis_jabatan" id="jenis_jabatan" required>
                    <option value="" selected disabled>-- Pilihan --</option>
                    @php
                        $jenisJabatanOptions = ['Struktural', 'Fungsional Tertentu', 'Fungsional Pelaksana', 'Tenaga Ahli Daya', 'Tenaga Mitra'];
                    @endphp
                    @foreach ($jenisJabatanOptions as $option)
                        <option value="{{ $option }}" {{ old('jenis_jabatan', $jabatan->jenis_jabatan ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            @error('jenis_jabatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3 form-group">
            <label for="status" class="col-md-4 col-lg-3 col-form-label">Status Hukum</label>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="status" id="status" required>
                    <option value="" selected disabled>-- Pilihan --</option>
                    @php
                        $statusOptions = [
                            'Aktif', 'CLTN', 'Tugas Belajar', 'Pemberhentian sementara', 'Penerima Uang Tunggu',
                            'Wajib Militer', 'Pejabat Negara', 'Proses Banding BAPEK', 'Masa Persiapan Pensiun',
                            'Pensiun', 'Calon CPNS', 'Hukuman Disiplin'
                        ];
                    @endphp
                    @foreach ($statusOptions as $option)
                        <option value="{{ $option }}" {{ old('status', $jabatan->status ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <label for="pangkat" class="col-md-4 col-lg-3 col-form-label">Pangkat / Gol. Ruang</label>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="pangkat" id="pangkat">
                    <option value="" selected disabled>-- Pilihan --</option>
                    @php
                        $pangkatOptions = [
                            'Juru Muda', 'Juru Muda Tingkat I', 'Juru ', 'Juru Tingkat I',
                            'Pengatur Muda', 'Pengatur Muda Tingkat I', 'Pengatur', 'Pengatur Tingkat I',
                            'Penata Muda', 'Penata Muda Tingkat I', 'Penata', 'Penata Tingkat I',
                            'Pembina', 'Pembina Tingkat I', 'Pembina Utama Muda', 'Pembina Utama Madya',
                            'Pembina Utama'
                        ];
                    @endphp
                    @foreach ($pangkatOptions as $option)
                        <option value="{{ $option }}" {{ old('pangkat', $jabatan->pangkat ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
                @error('pangkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="golongan_ruang" id="golongan_ruang">
                    <option value="" selected disabled>-- Pilihan --</option>
                    @php
                        $golonganRuangOptions = [
                            'I/a', 'I/b', 'I/c', 'I/d',
                            'II/a', 'II/b', 'II/c', 'II/d',
                            'III/a', 'II/b', 'III/c', 'III/d',
                            'IV/a', 'IV/b', 'IV/c', 'IV/d',
                            'IV/e'
                        ];
                    @endphp
                    @foreach ($golonganRuangOptions as $option)
                        <option value="{{ $option }}" {{ old('golongan_ruang', $jabatan->golongan_ruang ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
                @error('golongan_ruang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="tmt_golongan_ruang" class="col-md-4 col-lg-3 col-form-label">TMT Golongan Ruang</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tmt_golongan_ruang" type="text" class="form-control @error('tmt_golongan_ruang') is-invalid @enderror" id="tmt_golongan_ruang" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tmt_golongan_ruang', $jabatan->tmt_golongan_ruang ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tmt_golongan_ruang" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tmt_golongan_ruang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="golongan_ruang_cpns" class="col-md-4 col-lg-3 col-form-label">Golongan Ruang CPNS</label>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="golongan_ruang_cpns" id="golongan_ruang_cpns">
                    <option value="" selected disabled>-- Pilihan --</option>
                    @php
                        $golonganRuangCPNSOptions = [
                            'I/a', 'I/b', 'I/c', 'I/d',
                            'II/a', 'II/b', 'II/c', 'II/d',
                            'III/a', 'II/b', 'III/c', 'III/d',
                            'IV/a', 'IV/b', 'IV/c', 'IV/d',
                            'IV/e'
                        ];
                    @endphp
                    @foreach ($golonganRuangCPNSOptions as $option)
                        <option value="{{ $option }}" {{ old('golongan_ruang_cpns', $jabatan->golongan_ruang_cpns ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
                @error('golongan_ruang_cpns')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="tmt_golongan_ruang_cpns" class="col-md-4 col-lg-3 col-form-label">TMT Golongan Ruang CPNS</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tmt_golongan_ruang_cpns" type="text" class="form-control @error('tmt_golongan_ruang_cpns') is-invalid @enderror" id="tmt_golongan_ruang_cpns" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tmt_golongan_ruang_cpns', $jabatan->tmt_golongan_ruang_cpns ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tmt_golongan_ruang_cpns" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tmt_golongan_ruang_cpns')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <label for="tmt_pns" class="col-md-4 col-lg-3 col-form-label">TMT PNS</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tmt_pns" type="text" class="form-control @error('tmt_pns') is-invalid @enderror" id="tmt_pns" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tmt_pns', $jabatan->tmt_pns ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tmt_pns" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tmt_pns')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="eselon" class="col-md-4 col-lg-3 col-form-label">Eselon</label>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Default select example" name="eselon" id="eselon">
                    <option value="" selected>-- Pilihan --</option>
                    @php
                        $eselonOptions = ['II.b', 'III.a', 'III.b', 'IV.a', 'IV.b', 'Kepala Instalasi', 'Kepala Ruang'];
                    @endphp
                    @foreach ($eselonOptions as $option)
                        <option value="{{ $option }}" {{ old('eselon', $jabatan->eselon ?? '') == $option ? 'selected': '' }} >{{ $option }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="sk_pengangkatan_blud" class="col-md-4 col-lg-3 col-form-label">SK Pengangkatan Pegawai BLUD</label>
            <div class="col-md-4 col-lg-3">
                <input name="sk_pengangkatan_blud" type="text" class="form-control @error('sk_pengangkatan_blud') is-invalid @enderror" id="sk_pengangkatan_blud" value="{{ old('sk_pengangkatan_blud', $jabatan->sk_pengangkatan_blud ?? '') }}">
                @error('sk_pengangkatan_blud')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <label for="tgl_sk_pengangkatan_blud" class="col-md-4 col-lg-3 col-form-label">Tanggal SK Pengangkatan Pegawai BLUD</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tgl_sk_pengangkatan_blud" type="text" class="form-control @error('tgl_sk_pengangkatan_blud') is-invalid @enderror" id="tgl_sk_pengangkatan_blud" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tgl_sk_pengangkatan_blud', $jabatan->tgl_sk_pengangkatan_blud ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tgl_sk_pengangkatan_blud" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                @error('tgl_sk_pengangkatan_blud')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="mou_awal_blud" class="col-md-4 col-lg-3 col-form-label">MOU Awal Pegawai BLUD</label>
            <div class="col-md-4 col-lg-3">
                <input name="mou_awal_blud" type="text" class="form-control @error('mou_awal_blud') is-invalid @enderror" id="mou_awal_blud" value="{{ old('mou_awal_blud', $jabatan->mou_awal_blud ?? '') }}">
                @error('mou_awal_blud')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <label for="tgl_mou_awal_blud" class="col-md-4 col-lg-3 col-form-label">Tanggal MOU Awal Pegawai BLUD</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tgl_mou_awal_blud" type="text" class="form-control @error('tgl_mou_awal_blud') is-invalid @enderror" id="tgl_mou_awal_blud" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tgl_mou_awal_blud', $jabatan->tgl_mou_awal_blud ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tgl_mou_awal_blud" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tgl_mou_awal_blud')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="tmt_awal_mou_blud" class="col-md-4 col-lg-3 col-form-label">TMT Awal MOU BLUD</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tmt_awal_mou_blud" type="text" class="form-control @error('tmt_awal_mou_blud') is-invalid @enderror" id="tmt_awal_mou_blud" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tmt_awal_mou_blud', $jabatan->tmt_awal_mou_blud ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tmt_awal_mou_blud" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tmt_awal_mou_blud')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <label for="tmt_akhir_mou_blud" class="col-md-4 col-lg-3 col-form-label">S/D TMT Akhir Mou BLUD</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tmt_akhir_mou_blud" type="text" class="form-control @error('tmt_akhir_mou_blud') is-invalid @enderror" id="tmt_akhir_mou_blud" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tmt_akhir_mou_blud', $jabatan->tmt_akhir_mou_blud ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tmt_akhir_mou_blud" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tmt_akhir_mou_blud')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="mou_akhir_blud" class="col-md-4 col-lg-3 col-form-label">MOU Akhir Pegawai BLUD</label>
            <div class="col-md-4 col-lg-3">
                <input name="mou_akhir_blud" type="text" class="form-control @error('mou_akhir_blud') is-invalid @enderror" id="mou_akhir_blud" value="{{ old('mou_akhir_blud', $jabatan->mou_akhir_blud ?? '') }}">
                @error('mou_akhir_blud')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <label for="tgl_akhir_blud" class="col-md-4 col-lg-3 col-form-label">Tanggal Akhir Pegawai BLUD</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tgl_akhir_blud" type="text" class="form-control @error('tgl_akhir_blud') is-invalid @enderror" id="tgl_akhir_blud" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tgl_akhir_blud', $jabatan->tgl_akhir_blud ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tgl_akhir_blud" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tgl_akhir_blud')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="tmt_mou_akhir" class="col-md-4 col-lg-3 col-form-label">TMT MOU Akhir</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tmt_mou_akhir" type="text" class="form-control @error('tmt_mou_akhir') is-invalid @enderror" id="tmt_mou_akhir" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tmt_mou_akhir', $jabatan->tmt_mou_akhir ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tmt_mou_akhir" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tmt_mou_akhir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <label for="tmt_akhir_mou" class="col-md-4 col-lg-3 col-form-label">S/D TMT Akhir MOU</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tmt_akhir_mou" type="text" class="form-control @error('tmt_akhir_mou') is-invalid @enderror" id="tmt_akhir_mou" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tmt_akhir_mou', $jabatan->tmt_akhir_mou ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tmt_akhir_mou" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tmt_akhir_mou')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="no_mou_mitra" class="col-md-4 col-lg-3 col-form-label">No. MOU Pegawai Mitra</label>
            <div class="col-md-4 col-lg-3">
                <input name="no_mou_mitra" type="text" class="form-control @error('no_mou_mitra') is-invalid @enderror" id="no_mou_mitra" value="{{ old('no_mou_mitra', $jabatan->no_mou_mitra ?? '') }}">
                @error('no_mou_mitra')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <label for="tgl_mou_mitra" class="col-md-4 col-lg-3 col-form-label">Tanggal MOU Pegawai Mitra</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tgl_mou_mitra" type="text" class="form-control @error('tgl_mou_mitra') is-invalid @enderror" id="tgl_mou_mitra" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tgl_mou_mitra', $jabatan->tgl_mou_mitra ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tgl_mou_mitra" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tgl_mou_mitra')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="tmt_mou_mitra" class="col-md-4 col-lg-3 col-form-label">TMT MOU Mitra</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tmt_mou_mitra" type="text" class="form-control @error('tmt_mou_mitra') is-invalid @enderror" id="tmt_mou_mitra" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tmt_mou_mitra', $jabatan->tmt_mou_mitra ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tmt_mou_mitra" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tmt_mou_mitra')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <label for="tmt_akhir_mou_mitra" class="col-md-4 col-lg-3 col-form-label">S/D TMT Akhir MOU Mitra</label>
            <div class="col-md-4 col-lg-3">
                <div class="input-group">
                    <input name="tmt_akhir_mou_mitra" type="text" class="form-control @error('tmt_akhir_mou_mitra') is-invalid @enderror" id="tmt_akhir_mou_mitra" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ uiDate(old('tmt_akhir_mou_mitra', $jabatan->tmt_akhir_mou_mitra ?? '')) }}">
                    <button class="btn btn-outline-secondary" type="button" for="tmt_akhir_mou_mitra" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                </div>
                    @error('tmt_akhir_mou_mitra')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="text-center p-2">
                <button type="submit" class="btn btn-primary">
                    @isset($jabatan)
                        Update Jabatan
                    @else
                        Tambah Jabatan
                    @endisset
                </button>
            </div>
        </div>
    </form>
</div><!-- End Create Jabatan -->