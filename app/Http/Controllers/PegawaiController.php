<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {            
        $query = Pegawai::with('jabatan'); // eager load relasi jabatans

        // Filter berdasarkan jenis kepegawaian
        if ($request->filled('jenis_kepegawaian')) {
            $query->whereHas('jabatan', function ($q) use ($request) {
                $q->where('jenis_kepegawaian', $request->jenis_kepegawaian);
            });
        }

        // Filter berdasarkan nama jabatan dari relasi jabatan
        if ($request->filled('nama_jabatan')) {
            $query->whereHas('jabatan', function ($q) use ($request) {
                $q->where('nama_jabatan', $request->nama_jabatan);
            });
        }

        // Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                ->orWhere('nip', 'like', "%$search%")
                ->orWhere('jenis_kelamin', 'like', "%$search%");
            });
        }

        // pagination
        $perPage = $request->input('per_page', 10);
        $pegawais = $query->paginate($perPage)->appends($request->query());

        // Data untuk filter
        $jeniskepegawaianList = \App\Models\Jabatan::distinct()->pluck('jenis_kepegawaian');
        $namajabatanList = \App\Models\Jabatan::distinct()->pluck('nama_jabatan');

        // Jika request berupa AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.pegawai.index', compact('pegawais'))->render()
            ]);
        }

        // Return view dengan semua data
        return view('dashboard.pegawai.index', compact(
            'pegawais',
            'namajabatanList',
            'jeniskepegawaianList'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data
        $validatedData = $request->validate([
            'image' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,bmp',
            'nip' => 'required',
            'nip_lama' => 'nullable',
            'no_karpeg' => 'nullable',
            'no_kpe' => 'nullable',
            'no_ktp' => 'required',
            'no_npwp' => 'nullable',
            'nama' => 'required',
            'gelar_depan' => 'nullable|max:5',
            'gelar_belakang' => 'nullable|max:5',
            'tempat_lahir' => 'required|max:45',
            'tanggal_lahir' => 'required|date_format:d-m-Y',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'desa' => 'nullable',
            'kecamatan' => 'nullable',
            'kabupaten' => 'nullable',
            'provinsi' => 'nullable',
            'pos' => 'nullable',
            'telepon' => 'required',
        ]);

        // Konversi tanggal_lahir dari dd-mm-yyyy ke YYYY-MM-DD sebelum disimpan
        if (!empty($validatedData['tanggal_lahir'])) {
            $validatedData['tanggal_lahir'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_lahir'])->format('Y-m-d');
        }

        //upload image
        if ($request->file('image')) {
            // Simpan gambar baru di direktori 'foto-profile' pada disk 'public'
            $validatedData['image'] = $request->file('image')->store('foto-profile', 'public');
        }

        // Simpan ke database
        $pegawai = Pegawai::create($validatedData);

        // Redirect ke halaman show pegawai
        return redirect()->route('pegawai.show', $pegawai->id)->with('success', 'Berhasil Menambahkan Pegawai');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai, Request $request)
    {
        // load relasi jabatan
        $pegawai->load('jabatan');

        // Ambil data jabatan
        $jabatan = $pegawai->jabatan;

        return view('dashboard.partials.show', compact('pegawai', 'jabatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('dashboard.pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        // melakukan validasi data
        $validatedData = $request->validate([
            'image' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,bmp',
            'nip' => 'required',
            'nip_lama' => 'nullable',
            'no_karpeg' => 'nullable',
            'no_kpe' => 'nullable',
            'no_ktp' => 'required',
            'no_npwp' => 'nullable',
            'nama' => 'required',
            'gelar_depan' => 'nullable|max:5',
            'gelar_belakang' => 'nullable|max:5',
            'tempat_lahir' => 'required|max:45',
            'tanggal_lahir' => 'required|date_format:d-m-Y',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'desa' => 'nullable',
            'kecamatan' => 'nullable',
            'kabupaten' => 'nullable',
            'provinsi' => 'nullable',
            'pos' => 'nullable',
            'telepon' => 'required',
        ]);

        // Konversi tanggal_lahir dari dd-mm-yyyy ke YYYY-MM-DD sebelum disimpan
        if (!empty($validatedData['tanggal_lahir'])) {
            $validatedData['tanggal_lahir'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_lahir'])->format('Y-m-d');
        }
        
        // Upload image baru jika ada
        if ($request->hasFile('image')) {
            // Hapus image lama jika ada
            if ($pegawai->image && Storage::disk('public')->exists($pegawai->image)) {
                Storage::disk('public')->delete($pegawai->image);
            }

            // Simpan image baru
            $validatedData['image'] = $request->file('image')->store('foto-profile', 'public');
        }

        // Update ke database pegawai
        $pegawai->update($validatedData);

        return redirect()->route('pegawai.show', $pegawai->id)->with('success', 'Berhasil Memperbarui Pegawai');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        // Hapus image jika ada
        if ( $pegawai->image ) {
            Storage::delete($pegawai->image);
        }
        $pegawai->delete();// hapus data pegawai

        return redirect('/dashboard/pegawai')->with('success','Data Pegawai Berhasil Dihapus' );
    }

    public function rekapGolongan()
    {
        // Ambil jumlah pegawai berdasarkan golongan
        $rekap = Pegawai::select('golongan_ruang', DB::raw('count(*) as jumlah'))
        ->whereNotNull('golongan_ruang')
        ->groupBy('golongan_ruang')
        ->orderBy('golongan_ruang', 'desc')
        ->get();

    // Hitung jumlah pegawai tanpa golongan
    $pegawaiTanpaGolongan = Pegawai::whereNull('golongan_ruang')->count();

    // Ambil detail pegawai tanpa golongan
    $dataPegawaiTanpaGolongan = Pegawai::whereNull('golongan_ruang')->get();

    return view('dashboard.rekapitulasi.golongan', compact('rekap', 'pegawaiTanpaGolongan', 'dataPegawaiTanpaGolongan'));
    }
    
    public function rekapAgama()
    {
        // Ambil jumlah pegawai berdasarkan agama
        $rekap = Pegawai::select('agama', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('agama')
                        ->groupBy('agama')
                        ->orderBy('agama', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa Agama
        $pegawaiTanpaAgama = Pegawai::whereNull('agama')->count();

        // Ambil detail pegawai tanpa agama
        $dataPegawaiTanpaAgama = Pegawai::whereNull('agama')->get();

        return view('dashboard.rekapitulasi.agama', compact('rekap', 'pegawaiTanpaAgama' ,'dataPegawaiTanpaAgama'));
    }
    
    public function rekapJenisKelamin()
    {
        // Ambil jumlah pegawai berdasarkan jenis kelamin
        $rekap = Pegawai::select('jenis_kelamin', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('jenis_kelamin')
                        ->groupBy('jenis_kelamin')
                        ->orderBy('jenis_kelamin', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa jenis kelamin
        $pegawaiTanpaJenisKelamin = Pegawai::whereNull('jenis_kelamin')->count();

        // Ambil detail pegawai tanpa kelamin
        $dataPegawaiTanpaKelamin = Pegawai::whereNull('jenis_kelamin')->get();
        
        return view('dashboard.rekapitulasi.jenis-kelamin', compact('rekap', 'pegawaiTanpaJenisKelamin' ,'dataPegawaiTanpaKelamin'));
    }
    
    public function rekapStatusNikah()
    {
        // Ambil jumlah pegawai berdasarkan jenis kelamin
        $rekap = Pegawai::select('status_nikah', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('status_nikah')
                        ->groupBy('status_nikah')
                        ->orderBy('status_nikah', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa status nikah
        $pegawaiTanpaStatusNikah = Pegawai::whereNull('status_nikah')->count();

        // Ambil detail pegawai tanpa status nikah
        $dataPegawaiTanpaStatusNikah = Pegawai::whereNull('status_nikah')->get();

        return view('dashboard.rekapitulasi.status-nikah', compact('rekap', 'pegawaiTanpaStatusNikah' ,'dataPegawaiTanpaStatusNikah'));
    }

    public function getData($id)
    {
        // Mengambil data pegawai beserta relasi jabatan dan pendidikan
        $pegawai = Pegawai::with('jabatan', 'pendidikans')->findOrFail($id);

        // mengambil data yang diperlukan
        return response()->json([
            'nip' => $pegawai->nip ?? '-',
            'tempat_lahir' =>$pegawai->tempat_lahir ?? '-',
            'tanggal_lahir' =>$pegawai->tanggal_lahir ?? '-',
            'telepon' =>$pegawai->telepon ?? '-',
            'agama' =>$pegawai->agama ?? '-',
            'alamat' =>$pegawai->alamat_lengkap ?? '-',
            'tingkat' =>optional($pegawai->pendidikans)->tingkat ?? '-',
            'unit_kerja' => optional($pegawai->jabatan)->unit_kerja ?? '-',
            'nama_jabatan' => optional($pegawai->jabatan)->nama_jabatan ?? '-',
            'golongan_ruang' =>optional($pegawai->jabatan)->golongan_ruang?? '-',
            'pangkat' => optional($pegawai->jabatan)->pangkat ?? '-',
        ]);
    }

    public function rekapKGBPangkat(Request $request)
    {
        $tanggalSekarang = Carbon::now();

        // Ambil pegawai beserta relasi jabatan (ambil kolom yang diperlukan saja)
        $daftarPegawai = Pegawai::with(['jabatan' => function ($query) {
            $query->select(
                'id', 'pegawai_id',
                'golongan_ruang', 'tmt_golongan_ruang',
                'golongan_ruang_cpns', 'tmt_golongan_ruang_cpns',
                'tmt_jabatan'
            );
        }])->get(['id', 'nama']);

        // Kumpulkan pegawai yang masuk kriteria KGB dan Kenaikan Pangkat
        $koleksiKenaikanGajiBerkala = collect();
        $koleksiKenaikanPangkat    = collect();

        foreach ($daftarPegawai as $pegawai) {
            $jabatan = $pegawai->jabatan;
            if (!$jabatan) {
                continue; // lewati jika belum ada data jabatan
            }

            // Prioritaskan TMT golongan, jika kosong gunakan CPNS
            $tanggalMulaiGolongan = $jabatan->tmt_golongan_ruang ?? $jabatan->tmt_golongan_ruang_cpns;
            if (!$tanggalMulaiGolongan) {
                continue; // lewati jika TMT tidak ada
            }

            // Pastikan bertipe Carbon
            $tanggalMulaiGolongan = $tanggalMulaiGolongan instanceof Carbon
                ? $tanggalMulaiGolongan
                : Carbon::parse($tanggalMulaiGolongan);

            // Hitung masa kerja dalam tahun
            $masaKerjaTahun = $tanggalMulaiGolongan->diffInYears($tanggalSekarang);

            // KGB setiap 2 tahun sejak TMT golongan
            $jumlahKenaikanGaji = intdiv($masaKerjaTahun, 2);
            $tanggalKenaikanGajiTerakhir = (clone $tanggalMulaiGolongan)->addYears($jumlahKenaikanGaji * 2);

            // Masuk daftar KGB jika tanggal KGB terakhir sudah lewat atau sama dengan hari ini
            if ($tanggalKenaikanGajiTerakhir->lte($tanggalSekarang)) {
                $koleksiKenaikanGajiBerkala->push($pegawai);
            }

            // Contoh aturan: Kenaikan pangkat minimal 4 tahun masa kerja
            if ($masaKerjaTahun >= 4) {
                $koleksiKenaikanPangkat->push($pegawai);
            }
        }

        // Pagination terpisah untuk dua tabel
        $jumlahPerHalaman = 10;
        $halamanSaatIniKenaikanGajiBerkala = LengthAwarePaginator::resolveCurrentPage('kgb_page');
        $halamanSaatIniKenaikanPangkat     = LengthAwarePaginator::resolveCurrentPage('pangkat_page');

        $paginasiKenaikanGajiBerkala = new LengthAwarePaginator(
            $koleksiKenaikanGajiBerkala->forPage($halamanSaatIniKenaikanGajiBerkala, $jumlahPerHalaman),
            $koleksiKenaikanGajiBerkala->count(),
            $jumlahPerHalaman,
            $halamanSaatIniKenaikanGajiBerkala,
            ['path' => url()->current(), 'pageName' => 'kgb_page']
        );

        $paginasiKenaikanPangkat = new LengthAwarePaginator(
            $koleksiKenaikanPangkat->forPage($halamanSaatIniKenaikanPangkat, $jumlahPerHalaman),
            $koleksiKenaikanPangkat->count(),
            $jumlahPerHalaman,
            $halamanSaatIniKenaikanPangkat,
            ['path' => url()->current(), 'pageName' => 'pangkat_page']
        );

        return view('dashboard.pegawai.rekap-kgb-pangkat', [
            'dataKenaikanGajiBerkala' => $paginasiKenaikanGajiBerkala,
            'dataKenaikanPangkat'     => $paginasiKenaikanPangkat,
        ]);
    }
}
