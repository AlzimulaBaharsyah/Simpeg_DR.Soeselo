<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id', 'skpd', 'unit_kerja', 'pangkat', 'nama_jabatan', 'formasi_jabatan', 'formasi_jabatan_tingkat', 'formasi_jabatan_keterangan',
        'jenis_kepegawaian', 'jenis_jabatan', 'status', 'golongan_ruang', 'tmt_golongan_ruang',
        'golongan_ruang_cpns', 'tmt_golongan_ruang_cpns', 'tmt_pns', 'eselon', 'tmt_jabatan',
        'sk_pengangkatan_blud', 'tgl_sk_pengangkatan_blud', 'mou_awal_blud', 'tgl_mou_awal_blud', 'tmt_awal_mou_blud', 'tmt_akhir_mou_blud',
        'mou_akhir_blud', 'tgl_akhir_blud', 'tmt_mou_akhir', 'tmt_akhir_mou',
        'no_mou_mitra', 'tgl_mou_mitra', 'tmt_mou_mitra', 'tmt_akhir_mou_mitra'
    ];

    protected $casts = [
        'tmt_golongan_ruang'         => 'date',
        'tmt_golongan_ruang_cpns'    => 'date',
        'tmt_pns'                    => 'date',
        'tmt_jabatan'                => 'date',
        'tgl_sk_pengangkatan_blud'   => 'date',
        'tgl_mou_awal_blud'          => 'date',
        'tmt_awal_mou_blud'          => 'date',
        'tmt_akhir_mou_blud'         => 'date',
        'tgl_akhir_blud'             => 'date',
        'tmt_mou_akhir'              => 'date',
        'tmt_akhir_mou'              => 'date',
        'tgl_mou_mitra'              => 'date',
        'tmt_mou_mitra'              => 'date',
        'tmt_akhir_mou_mitra'        => 'date',
    ];
    
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
