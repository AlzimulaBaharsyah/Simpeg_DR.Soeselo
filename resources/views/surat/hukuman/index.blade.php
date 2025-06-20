@extends('surat.layouts.main')

@section('main')

<div class="pagetitle">
    <div class="pagetitle">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Daftar Surat Hukuman</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('surat') }}">E-surat</a></li>
                    <li class="breadcrumb-item active">Daftar Surat Hukuman</li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Pengajuan Surat Hukuman Title -->

<section class="row mt-4">
    <form method="GET" action="{{ route('tugas_belajar.index') }}" class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2 mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('tugas_belajar.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pengajuan
            </a>
        </div>
        <div style="min-width: 250px;">
            <div class="input-group">
                <input type="search" name="search" id="search" class="form-control" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> search
                </button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Jenis hukuman</th>
                <th>Waktu</th>
                <th>Tanggal Pengajuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hukumans as $hukuman)
            <tr>
                <td>{{ $hukuman->pegawai->nama }}</td>
                <td>{{ $hukuman->pegawai->nip }}</td>
                <td>{{ $hukuman->pegawai->jabatan->nama ?? '-' }}</td>
                <td>{{ ucfirst($hukuman->jenis_hukuman) }}</td>
                <td>{{ ($hukuman->waktu) }}</td>
                <td>{{ \Carbon\Carbon::parse($hukuman->tanggal)->format('d-m-Y') }}</td>
                <td>
                    <a href="{{ route('hukuman.export', $hukuman->id) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-word"></i> Export
                    </a>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data hukuman yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Pagination -->
    {{ $hukumans->appends(request()->query())->links() }}
</div>

@endsection