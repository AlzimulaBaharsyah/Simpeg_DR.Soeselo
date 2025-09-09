@extends('dashboard.layouts.main')

@section('main')

@php
    use Carbon\Carbon;

    // Helper untuk format tanggal ke dd-mm-yyyy
    if (!function_exists('formatTanggalUntukTampilan')) {
        function formatTanggalUntukTampilan($nilai) {
            if (empty($nilai)) return '-';
            try {
                if ($nilai instanceof \Carbon\Carbon) {
                    return $nilai->format('d-m-Y');
                }
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$nilai)) {
                    return Carbon::createFromFormat('Y-m-d', $nilai)->format('d-m-Y');
                }
                if (preg_match('/^\d{2}-\d{2}-\d{4}$/', (string)$nilai)) {
                    return $nilai;
                }
                return Carbon::parse($nilai)->format('d-m-Y');
            } catch (\Throwable $e) {
                return (string)$nilai;
            }
        }
    }

    // Helper untuk mengambil data golongan dan TMT dari relasi jabatan
    if (!function_exists('ambilDataGolonganDanTmt')) {
        function ambilDataGolonganDanTmt($pegawai) {
            $jabatan = $pegawai->jabatan ?? null;
            if (!$jabatan) return ['golongan' => '-', 'tmt' => '-'];

            $golongan = $jabatan->golongan_ruang ?: $jabatan->golongan_ruang_cpns;
            $tanggalMulaiGolongan = $jabatan->tmt_golongan_ruang ?: $jabatan->tmt_golongan_ruang_cpns;

            return [
                'golongan' => $golongan ?: '-',
                'tmt' => formatTanggalUntukTampilan($tanggalMulaiGolongan)
            ];
        }
    }
@endphp

<div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Pegawai | <small>Riwayat Kenaikan Gaji Berkala dan Kenaikan Pangkat</small></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">KGB dan Kenaikan Pangkat</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pegawai Title -->

<div class="container-fluid">

    {{-- ================== REKAP KGB ================== --}}
    <h4 class="mb-3">Rekap Kenaikan Gaji Berkala</h4>
    <table class="table table-bordered table-sm align-middle">
        <thead class="table-primary">
            <tr class="text-center">
                <th style="width:60px">No</th>
                <th>Nama Pegawai</th>
                <th style="width:160px">Golongan</th>
                <th style="width:170px">TMT Golongan</th>
                <th style="width:100px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataKenaikanGajiBerkala as $index => $pegawai)
                @php
                    $rekap = ambilDataGolonganDanTmt($pegawai);
                @endphp
                <tr>
                    <td class="text-center">{{ ($dataKenaikanGajiBerkala->currentPage() - 1) * $dataKenaikanGajiBerkala->perPage() + $index + 1 }}</td>
                    <td>{{ $pegawai->nama }}</td>
                    <td class="text-center">{{ $rekap['golongan'] }}</td>
                    <td class="text-center">{{ $rekap['tmt'] }}</td>
                    <td class="text-center">
                        <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada pegawai yang waktunya kenaikan gaji berkala.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-2">
        {{ $dataKenaikanGajiBerkala->appends(['pangkat_page' => request('pangkat_page')])->links() }}
    </div>

    {{-- ================== REKAP PANGKAT ================== --}}
    <h4 class="mb-3 mt-5">Rekap Kenaikan Pangkat</h4>
    <table class="table table-bordered table-sm align-middle">
        <thead class="table-success">
            <tr class="text-center">
                <th style="width:60px">No</th>
                <th>Nama Pegawai</th>
                <th style="width:160px">Golongan</th>
                <th style="width:170px">TMT Golongan</th>
                <th style="width:100px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataKenaikanPangkat as $index => $pegawai)
                @php
                    $rekap = ambilDataGolonganDanTmt($pegawai);
                @endphp
                <tr>
                    <td class="text-center">{{ ($dataKenaikanPangkat->currentPage() - 1) * $dataKenaikanPangkat->perPage() + $index + 1 }}</td>
                    <td>{{ $pegawai->nama }}</td>
                    <td class="text-center">{{ $rekap['golongan'] }}</td>
                    <td class="text-center">{{ $rekap['tmt'] }}</td>
                    <td class="text-center">
                        <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-sm btn-success">Detail</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada pegawai yang waktunya naik pangkat.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-2">
        {{ $dataKenaikanPangkat->appends(['kgb_page' => request('kgb_page')])->links() }}
    </div>

</div>

@endsection
