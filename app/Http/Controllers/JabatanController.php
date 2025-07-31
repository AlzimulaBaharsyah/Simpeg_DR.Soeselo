<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Jabatan::query();

        // Cek apakah ada pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%$search%")
                ->orWhere('skpd', 'like', "%$search%")
                ->orWhere('eselon', 'like', "%$search%");
        }

        // Ambil jumlah data per halaman dari request (default 10)
        $perPage = $request->input('per_page', 10);
        $jabatans = $query->paginate($perPage)->appends($request->query());

        // Jika request, kembalikan seluruh view index tetapi hanya refresh bagian yang dibutuhkan
        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.jabatan.index', compact('jabatans'))->render()
            ]);
        }

        $jabatans = Jabatan::with('pegawai')->paginate($perPage);
        return view('dashboard.jabatan.index', compact('jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('dashboard.jabatan.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'skpd'=>'required',
            'unit_kerja'=>'required',
            'nama_jabatan'=>'required',
            'formasi_jabatan'=>'nullable',
            'formasi_jabatan_tingkat'=>'nullable',
            'formasi_jabatan_keterangan'=>'nullable',
            'jenis_kepegawaian'=>'required',
            'jenis_jabatan'=>'required',
            'status'=>'required',
            'pangkat'=>'nullable',
            'golongan_ruang'=>'nullable',
            'tmt_golongan_ruang'=>'nullable',
            'golongan_ruang_cpns'=>'nullable',
            'tmt_golongan_ruang_cpns'=>'nullable',
            'tmt_pns'=>'nullable',
            'eselon'=>'nullable',
            'sk_pengangkatan_blud'=>'nullable',
            'tgl_sk_pengangkatan_blud'=>'nullable|date',
            'mou_awal_blud'=>'nullable',
            'tgl_mou_awal_blud'=>'nullable|date',
            'tmt_awal_mou_blud'=>'nullable|date',
            'tmt_akhir_mou_blud'=>'nullable|date',
            'mou_akhir_blud'=>'nullable',
            'tgl_akhir_blud'=>'nullable|date',
            'tmt_mou_akhir'=>'nullable|date',
            'tmt_akhir_mou'=>'nullable|date',
            'no_mou_mitra'=>'nullable',
            'tgl_mou_mitra'=>'nullable|date',
            'tmt_mou_mitra'=>'nullable|date',
            'tmt_akhir_mou_mitra'=>'nullable|date',
        ]);

        Jabatan::create($request->all());
        return redirect()->back()
        ->with('success', 'Jabatan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pegawai = Pegawai::with('jabatan')->findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        $pegawais = Pegawai::all();
        return view('dashboard.jabatan.edit', compact('jabatan', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'skpd'=>'required',
            'unit_kerja'=>'required',
            'nama_jabatan'=>'required',
            'formasi_jabatan'=>'nullable',
            'formasi_jabatan_tingkat'=>'nullable',
            'formasi_jabatan_keterangan'=>'nullable',
            'jenis_kepegawaian'=>'required',
            'jenis_jabatan'=>'required',
            'status'=>'required',
            'pangkat'=>'nullable',
            'golongan_ruang'=>'nullable',
            'tmt_golongan_ruang'=>'nullable',
            'golongan_ruang_cpns'=>'nullable',
            'tmt_golongan_ruang_cpns'=>'nullable',
            'tmt_pns'=>'nullable',
            'eselon'=>'nullable',
            'sk_pengangkatan_blud'=>'nullable',
            'tgl_sk_pengangkatan_blud'=>'nullable|date',
            'mou_awal_blud'=>'nullable',
            'tgl_mou_awal_blud'=>'nullable|date',
            'tmt_awal_mou_blud'=>'nullable|date',
            'tmt_akhir_mou_blud'=>'nullable|date',
            'mou_akhir_blud'=>'nullable',
            'tgl_akhir_blud'=>'nullable|date',
            'tmt_mou_akhir'=>'nullable|date',
            'tmt_akhir_mou'=>'nullable|date',
            'no_mou_mitra'=>'nullable',
            'tgl_mou_mitra'=>'nullable|date',
            'tmt_mou_mitra'=>'nullable|date',
            'tmt_akhir_mou_mitra'=>'nullable|date',
        ]);

        $jabatan->update($request->all());
        return redirect()->back()
        ->with('success', 'Jabatan Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);

        if (!$jabatan) {
            return redirect()->back()->with('error', 'jabatan tidak ditemukan!');
        }

        $jabatan->delete();
        return redirect()->back()->with('success', 'jabatan berhasil dihapus!');
    }

    public function rekapKepegawaian()
    {
        // Ambil jumlah pegawai berdasarkan jabatan
        $rekap = Jabatan::select('jenis_kepegawaian', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('jenis_kepegawaian')
                        ->groupBy('jenis_kepegawaian')
                        ->orderBy('jenis_kepegawaian', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa jabatan
        $pegawaiTanpaKepegawaian = Jabatan::whereNull('jenis_kepegawaian')->count();

        // Ambil detail pegawai tanpa jabatan
        $dataPegawaiTanpaKepegawaian = Jabatan::whereNull('jenis_kepegawaian')->get();

        return view('dashboard.rekapitulasi.kepegawaian', compact('rekap', 'pegawaiTanpaKepegawaian', 'dataPegawaiTanpaKepegawaian'));
    }

    public function rekapJabatan()
    {
        // Ambil jumlah pegawai berdasarkan jabatan
        $rekap = Jabatan::select('nama_jabatan', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('nama_jabatan')
                        ->groupBy('nama_jabatan')
                        ->orderBy('nama_jabatan', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa jabatan
        $pegawaiTanpaJabatan = Jabatan::whereNull('nama_jabatan')->count();

        // Ambil detail pegawai tanpa jabatan
        $dataPegawaiTanpaJabatan = Jabatan::whereNull('nama_jabatan')->get();

        return view('dashboard.rekapitulasi.jabatan', compact('rekap', 'pegawaiTanpaJabatan', 'dataPegawaiTanpaJabatan'));
    }

    public function rekapEselon()
    {
        // Ambil jumlah pegawai berdasarkan eselon
        $rekap = Jabatan::select('eselon', DB::raw('count(*) as jumlah'))
                        ->whereNotNull('eselon')
                        ->groupBy('eselon')
                        ->orderBy('eselon', 'desc')
                        ->get();

        // Hitung jumlah pegawai tanpa eselon
        $pegawaiTanpaEselon = Jabatan::whereNull('eselon')->count();

        // Ambil detail pegawai tanpa eselom
        $dataPegawaiTanpaEselon = Jabatan::whereNull('eselon')->get();

        return view('dashboard.rekapitulasi.eselon', compact('rekap', 'pegawaiTanpaEselon', 'dataPegawaiTanpaEselon'));
    }
}
