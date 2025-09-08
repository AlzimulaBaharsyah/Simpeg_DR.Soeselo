@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Riwayat | <small>Ijin Belajar</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ijin Belajar</li>
                        </ol>
                    </nav>
                </div>
                <div class="col">
                    <div class="text-end">
                        <a href="{{ route('ijinbelajar.create') }}"><button type="button" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah ijinbelajar</button></a>
                    </div>
                </div>
            </div>
        </div><!-- End Ijin Belajar Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Ijin Belajar view -->
            <div class="view">
                <div class="row align-items-center mb-3">
                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-center mb-3 mb-md-0">
                        <form method="GET" action="{{ route('ijinbelajar.index') }}" class="d-flex align-items-center">
                            <label for="per_page" class="me-2 text-nowrap">Show:</label>
                            <select name="per_page" id="per_page" class="form-select w-auto me-2" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <label class="text-nowrap">Entries</label>
                            @if (request()->has('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                        </form>
                    </div>
                    
                    <div class="col-12 col-md-6 col-lg-4 offset-lg-4">
                        <form action="{{ route('ijinbelajar.index') }}" method="GET">
                            @if (request()->has('per_page'))
                                <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                            @endif
                            <div class="input-group">
                                <input type="search" name="search" id="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-search"></i> search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive small">
                    <table class="table table-bordered table-striped table-hover align-middle text-center">
                        <thead>
                            <tr class="text-center align-middle">
                                <th style="width: 50px;">No</th>
                                <th>Pegawai</th>
                                <th>Tingkat ijinbelajar</th>
                                <th>Jenis Bantuan</th>
                                <th>Nama Sekolah</th>
                                <th>Tahun Lulus</th>
                                <th>No Ijazah</th>
                                <th>Tanggal Ijazah</th>
                                <th style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($ijinbelajars->isEmpty())
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Data ijin belajar tidak ditemukan.</td>
                                </tr>                                
                            @else
                                @foreach ($ijinbelajars as $key => $ijinbelajar)
                                <tr>
                                    <td class="text-center">{{ $ijinbelajars->firstItem() + $key }}</td>
                                    <td>
                                        {{ $ijinbelajar->pegawai->nip }} - {{ $ijinbelajar->pegawai->nama_lengkap }}
                                    </td>
                                    <td>{{ $ijinbelajar->tingkat_ijin }}</td>
                                    <td>{{ $ijinbelajar->jenis_ijin }}</td>
                                    <td>{{ $ijinbelajar->nama_ijin }}</td>
                                    <td>{{ $ijinbelajar->tahun_lulus_ijin }}</td>
                                    <td>{{ $ijinbelajar->no_ijazah_ijin }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ijinbelajar->tanggal_ijazah)->translatedFormat('d F Y') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('pegawai.show', $ijinbelajar->pegawai->id) }}" onclick="localStorage.setItem('activePegawaiTab', '#anak')" class="btn btn-success btn-sm" title="Detail"><i class="bi bi-eye"></i> Detail</a>
                                        </div>
                                    </td>
                                </tr>                                
                                @endforeach
                            @endif                            
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    {{ $ijinbelajars->appends(request()->query())->links() }}
                </div>
            </div><!-- End Ijin Belajar view -->

        </div>
        </section>

@endsection