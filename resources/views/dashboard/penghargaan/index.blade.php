@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Riwayat | <small>Penghargaan</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Penghargaan</li>
                        </ol>
                    </nav>
                </div>
                <div class="col">
                    <div class="text-end">
                        <a href="{{ route('penghargaan.create') }}"><button type="button" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah penghargaan</button></a>
                    </div>
                </div>
            </div>
        </div><!-- End Penghargaan Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Penghargaan view -->
            <div class="view">
                <div class="row align-items-center mb-3">
                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-center mb-3 mb-md-0">
                        <form method="GET" action="{{ route('penghargaan.index') }}" class="d-flex align-items-center">
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
                        <form action="{{ route('penghargaan.index') }}" method="GET">
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
                                <th>Nama Tanda Jasa / Penghargaan</th>
                                <th>Pemberi</th>
                                <th>Tahun</th>
                                <th style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($penghargaans->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Data penghargaan tidak ditemukan.</td>
                                </tr>                                
                            @else
                                @foreach ($penghargaans as $key => $penghargaan)
                                <tr>
                                    <td class="text-center">{{ $penghargaans->firstItem() + $key }}</td>
                                    <td>
                                        {{ $penghargaan->pegawai->nip }} - {{ $penghargaan->pegawai->nama_lengkap }}
                                    </td>
                                    <td>{{ $penghargaan->nama }}</td>
                                    <td>{{ $penghargaan->pemberi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($penghargaan->tanggal_penghargaan)->translatedFormat('d F Y') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('pegawai.show', $penghargaan->pegawai->id) }}" onclick="localStorage.setItem('activePegawaiTab', '#penghargaan')" class="btn btn-success btn-sm" title="Detail"><i class="bi bi-eye"></i> Detail</a>
                                        </div>
                                    </td>
                                </tr>                                
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    {{ $penghargaans->appends(request()->query())->links() }}
                </div>            
            </div><!-- End Penghargaan view -->
        </div>
        </section>

@endsection