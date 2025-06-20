@extends('dashboard.layouts.main')

@section('main')

        <div class="pagetitle">
            <div class="row justify-content-between">
                <div class="col">
                    <h1>Anak | <small>Ubah Anak</small></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard/Anak">Riwayat Anak</a></li>
                            <li class="breadcrumb-item active">Ubah Anak</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div><!-- End Anak Edit Title -->

        <section class="section dashboard">
        <div class="row">

            <!-- Anak Edit -->
            <div class="container rounded shadow p-4">
                <form action="{{ route('anak.update', $anak->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="row mb-3">
                            <label for="pegawai_id" class="col-md-4 col-lg-3 col-form-label">1. Pegawai</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select" aria-label="Default select example" name="pegawai_id" id="pegawai_id" require>
                                    <option selected disabled>-- Pilih Pegawai --</option>
                                    @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}" {{ $anak->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                            {{ $pegawai->nip }} - {{ $pegawai->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Nama" class="col-md-4 col-lg-3 col-form-label">2. Nama</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') ?? $anak->nama }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="tempat_lahir" class="col-md-4 col-lg-3 col-form-label">3. Tempat Lahir</label>
                            <div class="col-md-4 col-lg-3">
                                <input name="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" value="{{ old('tempat_lahir') ?? $anak->tempat_lahir }}" required>
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <div class="input-group">
                                    <input name="tanggal_lahir" type="text" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ old('tanggal_lahir') ?? $anak->tanggal_lahir }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <button class="btn btn-outline-secondary" type="button" for="tanggal_lahir" id="button-addon2"><i class="bi bi-calendar3"></i></button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="status_keluarga" class="col-md-4 col-lg-3 col-form-label">4. Status Keluarga</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="status_keluarga" id="status_keluarga">
                                    <option selected>...</option>
                                    <option value="Anak Kandung" {{ (old('status_keluarga') ?? $anak->status_keluarga)=='Anak Kandung' ? 'selected': '' }} >1. Anak Kandung</option>
                                    <option value="Anak Angkat" {{ (old('status_keluarga') ?? $anak->status_keluarga)=='Anak Angkat' ? 'selected': '' }} >2. Anak Angkat</option>
                                    <option value="Anak Tiri" {{ (old('status_keluarga') ?? $anak->status_keluarga)=='Anak Tiri' ? 'selected': '' }} >3. Anak Tiri</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="status_tunjangan" class="col-md-4 col-lg-3 col-form-label">5. Status Tunjangan</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="status_tunjangan" id="status_tunjangan">
                                    <option selected>...</option>
                                    <option value="Dapat" {{ (old('status_tunjangan') ?? $anak->status_tunjangan)=='Dapat' ? 'selected': '' }} >1. Dapat</option>
                                    <option value="Tidak Dapat" {{ (old('status_tunjangan') ?? $anak->status_tunjangan)=='Tidak Dapat' ? 'selected': '' }} >2. Tidak Dapat</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jenis_kelamin" class="col-md-4 col-lg-3 col-form-label">6. Jenis Kelamin</label>
                            <div class="col-md-4 col-lg-3">
                                <select class="form-select" aria-label="Default select example" name="jenis_kelamin" id="jenis_kelamin" required>
                                    <option selected>...</option>
                                    <option value="Laki-laki" {{ (old('jenis_kelamin') ?? $anak->jenis_kelamin)=='Laki-laki' ? 'selected': '' }} >1. Laki-laki</option>
                                    <option value="Perempuan" {{ (old('jenis_kelamin') ?? $anak->jenis_kelamin)=='Perempuan' ? 'selected': '' }} >2. Perempuan</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            <div class="text-center p-2">
                                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> save</button>
                            </div>
                            <div class="text-center p-2">
                                <a href="{{ route('pegawai.show', $anak->pegawai_id) }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-90deg-left"></i> cancel</a>
                            </div>
                        </div>
                    </form>
            </div><!-- End Anak Edit -->
        </div>
        </section>

@endsection