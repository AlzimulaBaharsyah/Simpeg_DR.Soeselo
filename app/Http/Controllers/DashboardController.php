<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Pendidikan;
use App\Models\Penghargaan;
use App\Models\Diklatteknik;
use Illuminate\Http\Request;
use App\Models\Diklatjabatan;
use App\Models\Diklatfungsional;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPegawai = Pegawai::count();// jumlah Pegawai
        $jumlahPenghargaan = Penghargaan::count();// jumlah Penghargaan
        $jumlahdiklat = Diklatfungsional::count() + Diklatjabatan::count() + Diklatteknik::count();// jumlah Diklat

        // Rekapitulasi Data Pegawai
        $rekapGolongan = Jabatan::select('golongan_ruang', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('golongan_ruang')
            ->get();

        $rekapJabatan = Jabatan::select('nama_jabatan', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('nama_jabatan')
            ->get();

        $rekapEselon = Jabatan::select('eselon', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('eselon')
            ->get();

        $rekapKepegawaian = Jabatan::select('jenis_kepegawaian', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('jenis_kepegawaian')
            ->get();

        $rekapAgama = Pegawai::select('agama', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('agama')
            ->get();

        $rekapJenisKelamin = Pegawai::select('jenis_kelamin', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('jenis_kelamin')
            ->get();

        $rekapStatusNikah = Pegawai::select('status_nikah', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('status_nikah')
            ->get();

        $rekapPendidikan = Pendidikan::select('tingkat', DB::raw("COUNT(*) as jumlah"))
            ->groupBy('tingkat')
            ->get();

        return view('dashboard.index', compact(
            'jumlahPegawai', 'jumlahPenghargaan', 'jumlahdiklat', 'rekapGolongan', 
            'rekapJabatan', 'rekapEselon', 'rekapKepegawaian', 'rekapAgama', 'rekapJenisKelamin', 
            'rekapStatusNikah', 'rekapPendidikan'
        ));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $pegawais = Pegawai::where('nama', 'like', "%$search%")->get();

        return view('dashboard.result', compact('pegawais', 'search'));
    }

    public function headerNotification()
    {
        $tanggalSekarang = Carbon::now();

        // Ambil pegawai beserta data jabatan (relasi)
        $pegawaiList = Pegawai::with(['jabatan' => function ($query) {
            $query->select(
                'id', 'pegawai_id',
                'golongan_ruang', 'tmt_golongan_ruang',
                'golongan_ruang_cpns', 'tmt_golongan_ruang_cpns'
            );
        }])->get(['id', 'nama']);

        $daftarNotifikasi = [];

        foreach ($pegawaiList as $pegawai) {
            $jabatan = $pegawai->jabatan;

            if (!$jabatan) {
                continue; // skip kalau pegawai belum punya data jabatan
            }

            // Prioritaskan TMT Golongan Ruang PNS, kalau kosong ambil CPNS
            $tanggalMulaiGolongan = $jabatan->tmt_golongan_ruang ?? $jabatan->tmt_golongan_ruang_cpns;
            $golonganRuang = $jabatan->golongan_ruang ?? $jabatan->golongan_ruang_cpns;

            if (!$tanggalMulaiGolongan || !$golonganRuang) {
                continue; // skip kalau data dasar kosong
            }

            // Pastikan tanggal berupa Carbon
            $tanggalMulaiGolongan = $tanggalMulaiGolongan instanceof Carbon 
                ? $tanggalMulaiGolongan 
                : Carbon::parse($tanggalMulaiGolongan);

            // Hitung masa kerja dalam tahun
            $masaKerjaTahun = $tanggalMulaiGolongan->diffInYears($tanggalSekarang);

            // Kenaikan Gaji Berkala (KGB) diberikan setiap 2 tahun
            $jumlahKenaikanGaji = intdiv($masaKerjaTahun, 2);
            $tanggalKGBTerakhir = (clone $tanggalMulaiGolongan)->addYears($jumlahKenaikanGaji * 2);

            // Notifikasi KGB jika sudah waktunya diproses
            if ($tanggalKGBTerakhir->lte($tanggalSekarang)) {
                $daftarNotifikasi[] = [
                    'nama' => $pegawai->nama,
                    'jenis' => 'KGB',
                    'pesan' => "KGB untuk {$pegawai->nama} sudah bisa diproses (terakhir: " . $tanggalKGBTerakhir->format('d-m-Y') . ").",
                ];
            }

            // Notifikasi kenaikan pangkat, contoh aturan: minimal 4 tahun masa kerja
            if ($masaKerjaTahun >= 4) {
                $daftarNotifikasi[] = [
                    'nama' => $pegawai->nama,
                    'jenis' => 'PANGKAT',
                    'pesan' => "Pangkat untuk {$pegawai->nama} sudah bisa diusulkan (masa kerja: {$masaKerjaTahun} tahun).",
                ];
            }
        }

        return $daftarNotifikasi;
    }
}