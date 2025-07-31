@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Surat Cuti</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Pengajuan Surat Cuti / Ijin</li>
                </ol>
            </nav>
        </div>
    </div>
</div><div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Pengajuan Cuti Pegawai</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('cuti.store') }}" method="POST">
                        @csrf
                        <div class="mt-2 mb-4">
                            <h5 class="border-bottom pb-2">Data Pegawai</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pegawai_id">Nama Lengkap</label>
                                        <select class="form-select" aria-label="Default select example" name="pegawai_id" id="pegawai_id" required>
                                            <option selected>-- Pilih Pegawai --</option>
                                            @foreach($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}">{{ $pegawai->gelar_depan }}. {{ $pegawai->nama }}, {{ $pegawai->gelar_belakang }}</option>
                                            @endforeach
                                        </select>
                                        <small id="pegawai-loading" style="display:none; color:gray;">
                                            Mengambil data pegawai...
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nip">NIP</label>
                                        <input type="text" class="form-control" name="nip" id="nip" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_jabatan">Jabatan</label>
                                        <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unit_kerja">Unit Kerja</label>
                                        <input type="text" class="form-control" name="unit_kerja" id="unit_kerja" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Data Cuti</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_cuti">Jenis Cuti</label>
                                        <select class="form-control @error('jenis_cuti') is-invalid @enderror" id="jenis_cuti" name="jenis_cuti" required>
                                            <option value="">-- Pilih Jenis Cuti --</option>
                                            <option value="tahunan">Cuti Tahunan</option>
                                            <option value="melahirkan">Cuti Melahirkan</option>
                                            <option value="penting">Cuti di Luar Tanggungan Negara</option>
                                            <option value="sakit">Ijin Sakit</option>
                                            <option value="penting">Ijin Penting</option>
                                        </select>
                                        @error('jenis_cuti')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_mulai">Tanggal Mulai</label>
                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_selesai">Tanggal Selesai</label>
                                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lama_hari">Lama Cuti (hari)</label>
                                        <input type="number" class="form-control @error('lama_hari') is-invalid @enderror" id="lama_hari" name="lama_hari" min="1" readonly required>
                                        @error('lama_hari')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5 class="border-bottom pb-2">Data Atasan Langsung</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="atasan_jabatan">Jabatan Atasan</label>
                                            <input type="text" class="form-control" name="atasan_jabatan" id="atasan_jabatan" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="atasan_id">Nama Atasan</label>
                                            <select class="form-select" aria-label="Default select example" name="atasan_id" id="atasan_id" required>
                                                <option selected>-- Pilih Atasan --</option>
                                                @foreach($atasans as $atasan)
                                                <option value="{{ $atasan->id }}" data-nip="{{ $atasan->nip }}" data-nama="{{ $atasan->gelar_depan }}. {{ $atasan->nama }}, {{ $atasan->gelar_belakang }}">{{ $atasan->gelar_depan }}. {{ $atasan->nama }}, {{ $atasan->gelar_belakang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="atasan_nip">NIP Atasan</label>
                                            <input type="text" class="form-control" name="atasan_nip" id="atasan_nip" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hidden field untuk atasan_nama -->
                                <input type="hidden" name="atasan_nama" id="atasan_nama">
                            </div>
                            <div class="form-group">
                                <label for="alasan">Alasan Cuti</label>
                                <select class="form-control @error('alasan') is-invalid @enderror" id="alasan" name="alasan" required>
                                    <option value="">-- Pilih Alasan Cuti --</option>
                                    <option value="Cuti Tahunan">Cuti Tahunan</option>
                                    <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                                    <option value="Ijin Sakit">Sakit</option>
                                    <option value="Suami / Istri Meninggal">Suami / Istri Meninggal</option>
                                    <option value="Orang Tua / Mertua Pegawai Meninggal">Orang Tua / Mertua Pegawai Meninggal</option>
                                    <option value="Istri Pegawai Melahirkan">Istri Pegawai Melahirkan</option>
                                    <option value="Saudara Kandung Meninggal">Saudara Kandung Meninggal</option>
                                    <option value="Suami / Istri / Anak Pegawai Sakit Kera">Suami / Istri / Anak Pegawai Sakit Keras</option>
                                    <option value="Musibah Kebakaran / Kebajiran / Bencana Alam">Musibah Kebakaran / Kebajiran / Bencana Alam</option>
                                    <option value="Pegawai Menikah">Pegawai Menikah</option>
                                    <option value="Pernikahan Anak Pegawai">Pernikahan Anak Pegawai</option>
                                    <option value="Pernikahan Saudara Kandung Pegawai">Pernikahan Saudara Kandung Pegawai</option>
                                    <option value="Mengkhitankan, Membaptis Anak Pegawai">Mengkhitankan, Membaptis Anak Pegawai</option>
                                    <option value="Melaksanakan Ibadah haji untuk yang pertama kali">Melaksanakan Ibadah haji untuk yang pertama kali</option>
                                    <option value="Melaksanakan ibadah lainya diluar Ibadah Haji">Melaksanakan ibadah lainya diluar Ibadah Haji</option>
                                    <option value="Mendapatkan panggilan Dinas">Mendapatkan panggilan Dinas</option>
                                    <option value="Melaksanakan hak dalam Pemilu">Melaksanakan hak dalam Pemilu</option>
                                    <option value="Training, Seminar dan / atau Lokakarya">Training, Seminar dan / atau Lokakarya</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                                <div id="alasanLainnya" style="display: none; margin-top: 10px;">
                                    <input type="text" class="form-control" name="alasan_lainnya" id="alasan_lainnya" placeholder="Masukkan alasan cuti lainnya">
                                </div>
                                @error('alasan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat_cuti">Alamat Selama Cuti</label>
                                <textarea class="form-control @error('alamat_cuti') is-invalid @enderror" id="alamat_cuti" name="alamat_cuti" rows="2" required></textarea>
                                @error('alamat_cuti')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="telepon">Telepon/HP</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" rows="2" required></input>
                                @error('telepon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Ajukan Cuti
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector('form').addEventListener('submit', function (e) {
        const pegawaiId = document.getElementById('pegawai_id').value;
        const atasanId = document.getElementById('atasan_id').value;

        if (!pegawaiId || pegawaiId === '-- Pilih Pegawai --') {
            alert('Silakan pilih pegawai terlebih dahulu.');
            e.preventDefault();
        }
        if (!atasanId || atasanId === '-- Pilih Atasan --') {
            alert('Silakan pilih nama atasan terlebih dahulu.');
            e.preventDefault();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Select2
        $('#pegawai_id').select2({
            placeholder: "-- Pilih Pegawai --"
        });
        $('#atasan_id').select2({
            placeholder: "-- Pilih Atasan --"
        });
        $('#alasan').select2({
            placeholder: "-- Pilih Alasan Cuti --"
        });

        // Event listener untuk pegawai
        $('#pegawai_id').on('change', function () {
            const pegawaiId = $(this).val();

            if (!pegawaiId || pegawaiId === '-- Pilih Pegawai --') {
                clearPegawaiForm();
                return;
            }

            $('#pegawai-loading').show();

            fetch(`/api/pegawai/${pegawaiId}`)
                .then(response => {
                    if (!response.ok) throw new Error("Gagal ambil data pegawai");
                    return response.json();
                })
                .then(data => {
                    $('#nip').val(data.nip || '-');
                    $('#nama_jabatan').val(data.nama_jabatan || '-');
                    $('#unit_kerja').val(data.unit_kerja || '-');
                    
                    // Panggil fungsi untuk menentukan jabatan atasan
                    determineAtasanJabatan(data.nama_jabatan);
                })
                .catch(error => {
                    alert('Gagal mengambil data pegawai: ' + error.message);
                    clearPegawaiForm();
                })
                .finally(() => {
                    $('#pegawai-loading').hide();
                });
        });

        // Event listener untuk pilihan nama atasan
        $('#atasan_id').on('change', function() {
            const selectedOption = $(this).find(':selected');
            const atasanNip = selectedOption.data('nip');
            const atasanNama = selectedOption.data('nama');

            if (atasanNip) {
                $('#atasan_nip').val(atasanNip);
            } else {
                $('#atasan_nip').val('');
            }

            // Set hidden field atasan_nama
            if (atasanNama) {
                $('#atasan_nama').val(atasanNama);
            } else {
                $('#atasan_nama').val('');
            }
        });

        // Event listener untuk perhitungan lama cuti
        const tanggalMulai = document.getElementById('tanggal_mulai');
        const tanggalSelesai = document.getElementById('tanggal_selesai');
        const lamaCuti = document.getElementById('lama_hari');

        function hitungLamaCuti() {
            const mulai = new Date(tanggalMulai.value);
            const selesai = new Date(tanggalSelesai.value);

            if (tanggalMulai.value && tanggalSelesai.value && selesai >= mulai) {
                const selisih = Math.floor((selesai - mulai) / (1000 * 60 * 60 * 24)) + 1;
                lamaCuti.value = selisih;
            } else {
                lamaCuti.value = '';
            }
        }

        tanggalMulai.addEventListener('change', hitungLamaCuti);
        tanggalSelesai.addEventListener('change', hitungLamaCuti);

        // Event listener untuk alasan cuti lainnya
        $('#alasan').on('change', function() {
            const alasanLainnya = document.getElementById('alasanLainnya');
            
            if (this.value === 'lainnya') {
                alasanLainnya.style.display = 'block';
                document.getElementById('alasan_lainnya').required = true;
            } else {
                alasanLainnya.style.display = 'none';
                document.getElementById('alasan_lainnya').required = false;
            }
        });

        // Fungsi helper
        function clearPegawaiForm() {
            $('#nip').val('');
            $('#nama_jabatan').val('');
            $('#unit_kerja').val('');
            $('#atasan_jabatan').val('');
            $('#atasan_id').val('').trigger('change');
            $('#atasan_nip').val('');
            $('#atasan_nama').val('');
        }

        function determineAtasanJabatan(jabatanPegawai) {
            let atasanJabatan = '';

            const medis = [
                'Dokter Ahli Utama', 'Dokter Ahli Madya', 'Dokter Ahli Muda', 'Dokter Ahli Pertama',
                'Dokter Gigi Ahli Madya', 'Penata Kelola Layanan Kesehatan', 'Pengadministrasi Perkantoran'
            ];
            const keperawatan = [
                'Perawat Ahli Madya', 'Perawat Ahli Muda', 'Perawat Ahli Pertama', 'Perawat Penyelia', 'Perawat Mahir', 'Perawat Terampil',
                'Perawat Keahlian', 'Perawat Ketrampilan', 'Terapis Gigi dan Mulut Mahir', 'Terapis Gigi dan Mulut Terampil',
                'Bidan Ahli Madya', 'Bidan Ahli Muda', 'Bidan Ahli Pertama', 'Bidan Penyelia', 'Bidan Mahir', 'Bidan Terampil',
                'Penata Kelola Layanan Kesehatan ', 'Pengelola Layanan Kesehatan', 'Pengadministrasi Perkantoran ', 'Operator Layanan Operasional '
            ];
            const penunjang = [
                'Administrator Kesehatan Ahli Muda', 'Administrator Kesehatan Ahli Pertama', 'Apoteker Ahli Utama ', 'Apoteker Ahli Madya',
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
                'Pengelola Umum Operasional'
            ];
            const subbagianUmum = [
                'Pranata Komputer Ahli Pertama', 'Penyuluh Kesehatan Masyarakat Ahli Pertama',
                'Pranata Komputer Terampil', 'Arsiparis Terampil', 'Penelaah Teknis Kebijakan',
                'Penata Layanan Operasional', 'Pengelola Layanan Operasional', 'Pengolah Data dan Informasi',
                'Dokumentalis Hukum', 'Pengadministrasi Perkantoran', 'Operator Layanan Operasional',
                'Penata Layanan Operasional', 'Pengelola Layanan Operasional', 'Operator Layanan Operasional'
            ];
            const subbagianKepegawaian = [
                'Penata Layanan Operasional', 'Pengelola Layanan Operasional',
                'Operator Layanan Operasional', 'Pengadministrasi Perkantoran'
            ];
            const bagianTataUsaha = [
                'Kepala Subbagian Umum', 'Kepala Subbagian Kepegawaian'
            ];
            const bagianKeuangan = [
                'Analis Keuangan Pusat dan Daerah Ahli Muda', 'Analis Keuangan Pusat dan Daerah Ahli Pertama',
                'Penelaah Teknis Kebijakan', 'Fasilitator Pemerintahan', 'Pengolah Data dan Informasi ',
                'Operator Layanan Operasional '
            ];
            const bagianPerencanaan = [
                'Perencana Ahli Pertama', 'Penelaah Teknis Kebijakan', 'Pengadministrasi Perkantoran'
            ];
            const kepalaBidangPelayanan = [
                'Kepala Bidang Pelayanan Medis',
                'Kepala Bidang Pelayanan Keperawatan',
                'Kepala Bidang Pelayanan Penunjang'
            ];
            const kepalaBagianUmumKeuanganPerencanaan = [
                'Kepala Bagian Tata Usaha',
                'Kepala Bagian Keuangan',
                'Kepala Bagian Perencanaan'
            ];
            const wakilDirektur = [
                'Wakil Direktur Pelayanan',
                'Wakil Direktur Umum dan Keuangan'
            ];

            if (medis.includes(jabatanPegawai)) {
                atasanJabatan = 'Kepala Bidang Pelayanan Medis';
            } else if (keperawatan.includes(jabatanPegawai)) {
                atasanJabatan = 'Kepala Bidang Pelayanan Keperawatan';
            } else if (penunjang.includes(jabatanPegawai)) {
                atasanJabatan = 'Kepala Bidang Pelayanan Penunjang';
            } else if (subbagianUmum.includes(jabatanPegawai)) {
                atasanJabatan = 'Kepala Subbagian Umum';
            } else if (subbagianKepegawaian.includes(jabatanPegawai)) {
                atasanJabatan = 'Kepala Subbagian Kepegawaian';
            } else if (bagianTataUsaha.includes(jabatanPegawai)) {
                atasanJabatan = 'Kepala Bagian Tata Usaha';
            } else if (bagianKeuangan.includes(jabatanPegawai)) {
                atasanJabatan = 'Kepala Bagian Keuangan';
            } else if (bagianPerencanaan.includes(jabatanPegawai)) {
                atasanJabatan = 'Kepala Bagian Perencanaan';
            } else if (kepalaBidangPelayanan.includes(jabatanPegawai)) {
                atasanJabatan = 'Wakil Direktur Pelayanan';
            } else if (kepalaBagianUmumKeuanganPerencanaan.includes(jabatanPegawai)) {
                atasanJabatan = 'Wakil Direktur Umum dan Keuangan';
            } else if (wakilDirektur.includes(jabatanPegawai)) {
                atasanJabatan = 'Direktur RSUD dr Soeselo';
            } else {
                atasanJabatan = 'Tidak Ditemukan';
            }

            $('#atasan_jabatan').val(atasanJabatan);
        }
    });
</script>
@endsection