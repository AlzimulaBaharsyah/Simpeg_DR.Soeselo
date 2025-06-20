<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $fillable = [
        'pegawai_id', 'jenis_cuti', 'alasan', 'alasan_lainnya', 'lama_hari',
        'tanggal_mulai', 'tanggal_selesai', 'alamat_cuti', 'telepon', 'status'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
