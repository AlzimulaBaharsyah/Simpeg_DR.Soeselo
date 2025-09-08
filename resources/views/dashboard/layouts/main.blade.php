<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - Aplikasi Sistem Informasi Manajemen Kepegawaian RSUD SOESILO</title>
    <meta content="Aplikasi Sistem Informasi Manajemen Kepegawaian RSUD SOESILO" name="description">
    <meta content="Aplikasi Sistem Informasi Manajemen Kepegawaian RSUD SOESILO" name="keywords">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    
    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- CSS Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/dashboard/style.css') }}" rel="stylesheet">

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        @include('dashboard.layouts.header')

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        @include('dashboard.layouts.sidebar')

    </aside><!-- End Sidebar-->

    <main id="main" class="main">
        {{-- Notifikasi berhasil --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Notifikasi error --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-error">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @yield('main')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        @include('dashboard.layouts.footer')

    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- jQuery dan Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Apexcharts-->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        AOS.init();
        
        setTimeout(function() {
            let alertSuccess = document.getElementById('alert-success');
            let alertError = document.getElementById('alert-error');
            if (alertSuccess) {
                let bsAlert = bootstrap.Alert.getOrCreateInstance(alertSuccess);
                bsAlert.close();
            }
            if (alertError) {
                let bsAlert = bootstrap.Alert.getOrCreateInstance(alertError);
                bsAlert.close();
            }
        }, 2000);

        $(document).ready(function () {
            let dateFields = [
                {inputSelector: '[id^="tanggal_lahir"]', buttonSelector: '[for^="tanggal_lahir"]'},
                {inputSelector: '[id^="tanggal_nikah"]', buttonSelector: '[for^="tanggal_nikah"]'},
                {inputSelector: '[id^="tanggal_ijazah"]', buttonSelector: '[for^="tanggal_ijazah"]'},
                {inputSelector: '[id^="tanggal_ijazah_ijin"]', buttonSelector: '[for^="tanggal_ijazah_ijin"]'},
                {inputSelector: '[id^="tanggal_penghargaan"]', buttonSelector: '[for^="tanggal_penghargaan"]'},
                {inputSelector: '[id^="tanggal_selesai"]', buttonSelector: '[for^="tanggal_selesai"]'},
                {inputSelector: '[id^="tanggal_selesai_fungsional"]', buttonSelector: '[for^="tanggal_selesai_fungsional"]'},
                {inputSelector: '[id^="tanggal_selesai_jabatan"]', buttonSelector: '[for^="tanggal_selesai_jabatan"]'},
                {inputSelector: '[id^="tanggal_selesai_teknis"]', buttonSelector: '[for^="tanggal_selesai_teknis"]'},
                {inputSelector: '[id^="tmt_golongan_ruang"]', buttonSelector: '[for^="tmt_golongan_ruang"]'},
                {inputSelector: '[id^="tmt_golongan_ruang_cpns"]', buttonSelector: '[for^="tmt_golongan_ruang_cpns"]'},
                {inputSelector: '[id^="tmt_pns"]', buttonSelector: '[for^="tmt_pns"]'},
                {inputSelector: '[id^="tmt_jabatan"]', buttonSelector: '[for^="tmt_jabatan"]'},
                {inputSelector: '[id^="tahun_diklat_pimpinan"]', buttonSelector: '[for^="tahun_diklat_pimpinan"]'},
                {inputSelector: '[id^="tmt"]', buttonSelector: '[for^="tmt"]'},
                {inputSelector: '[id^="tmt_organisasi"]', buttonSelector: '[for^="tmt_organisasi"]'},
                {inputSelector: '[id^="tgl_sk_pengangkatan_blud"]', buttonSelector: '[for^="tgl_sk_pengangkatan_blud"]'},
                {inputSelector: '[id^="tgl_mou_awal_blud"]', buttonSelector: '[for^="tgl_mou_awal_blud"]'},
                {inputSelector: '[id^="tmt_awal_mou_blud"]', buttonSelector: '[for^="tmt_awal_mou_blud"]'},
                {inputSelector: '[id^="tmt_akhir_mou_blud"]', buttonSelector: '[for^="tmt_akhir_mou_blud"]'},
                {inputSelector: '[id^="tgl_akhir_blud"]', buttonSelector: '[for^="tgl_akhir_blud"]'},
                {inputSelector: '[id^="tmt_mou_akhir"]', buttonSelector: '[for^="tmt_mou_akhir"]'},
                {inputSelector: '[id^="tmt_akhir_mou"]', buttonSelector: '[for^="tmt_akhir_mou"]'},
                {inputSelector: '[id^="tgl_mou_mitra"]', buttonSelector: '[for^="tgl_mou_mitra"]'},
                {inputSelector: '[id^="tmt_mou_mitra"]', buttonSelector: '[for^="tmt_mou_mitra"]'},
                {inputSelector: '[id^="tmt_akhir_mou_mitra"]', buttonSelector: '[for^="tmt_akhir_mou_mitra"]'}
            ];

            dateFields.forEach(function(field) {
                $(field.inputSelector).each(function () {
                    if (!$(this).data('datepicker')) {
                        $(this).datepicker({
                            autoclose: true,
                            clearBtn: true,
                            format: "dd-mm-yyyy",
                            todayHighlight: true,
                            orientation: "bottom auto"
                        });
                    }
                });

                // Pastikan tombol show datepicker bekerja untuk semua ID dengan prefix sama
                $(field.buttonSelector).off('click').on('click', function () {
                    let targetId = $(this).attr('for');
                    $('#' + targetId).datepicker('show');
                });
            });
        });

        $(document).ready(function() {
            // Object configuration untuk kemudahan maintenance
            const select2Configs = {
                '#pegawai_id': {
                    placeholder: "-- Pilih Pegawai --",
                    allowClear: true
                },
                '#status_nikah': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#jenis_kepegawaian': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#unit_kerja': {
                    placeholder: "RSUD dr. Soeselo Slawi",
                    allowClear: true
                },
                '#nama_jabatan': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#pangkat': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#golongan_ruang': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#golongan_ruang_cpns': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#formasi_jabatan': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#formasi_jabatan_tingkat': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#formasi_jabatan_keterangan': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#kategori': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#jenis_jabatan': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#eselon': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#jenis_kelamin': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#agama': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#status': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#golongan_dari': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
                '#golongan_sampai': {
                    placeholder: "-- Pilihan --",
                    allowClear: true
                },
            };
            
            // Initialize semua Select2 elements
            Object.entries(select2Configs).forEach(([selector, config]) => {
                $(selector).select2({
                    ...config,
                    width: '100%' // Default option tambahan
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            let spanTanggal = document.getElementById("tanggalSekarang");

            if (spanTanggal) {
                // Ambil tanggal sekarang
                let today = new Date();
                let options = { day: "numeric", month: "long", year: "numeric" };
                let formattedDate = today.toLocaleDateString("id-ID", options);

                // Set value pada span
                spanTanggal.textContent = formattedDate;
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const perPageSelect = document.getElementById('per_page');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function () {
                    this.form.submit();
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const jenisKepegawaian = document.getElementById('jenis_kepegawaian');
            if (jenisKepegawaian) {
                jenisKepegawaian.addEventListener('change', function () {
                    this.form.submit();
                });
            }
        });

    </script>
</body>

</html>