@extends('dashboard.layouts.main')

@section('main')
    
    <div class="pagetitle">
        <div class="row justify-content-between">
            <div class="col">
                <h1>Result</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Pegawai Title -->

    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="text-center align-middle">
                    <th style="width: 50px;">No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin<br>Tempat Tanggal Lahir</th>
                    <th>Golongan<br>Jenis Kepegawaian</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawais as $index => $pegawai)
                <tr>
                    <td class="text-center">{{ $pegawais->firstItem() + $index }}</td>
                    <td>{{ $pegawai->nip }}</td>
                    <td>{{ $pegawai->gelar_depan }}{{ $pegawai->nama }}, {{ $pegawai->gelar_belakang }}</td>
                    <td>{{ $pegawai->jenis_kelamin }}<br>{{ $pegawai->tempat_lahir }}<br>{{ $pegawai->tanggal_lahir }}</td>
                    <td>{{ $pegawai->golongan_ruang }}<br>{{ $pegawai->jenis_kepegawaian }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                        <a href="{{ route('pegawai.show',['pegawai' => $pegawai->id]) }}" class="btn btn-success btn-sm" title="Detial"><i class="bi bi-eye"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada pegawai ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-90deg-left"></i> Kembali ke Dashboard</a>

@endsection