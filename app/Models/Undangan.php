<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Undangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tempat_surat',
        'tanggal_surat',
        'nomor',
        'sifat',
        'lampiran',
        'hal',
        'yth',
        'alamat',
        'pembuka_surat',
        'tanggal_acara',
        'hari',
        'waktu',
        'tempat',
        'acara',
        'penutup_surat',
        'penandatangan_id',
        'tembusan',
    ];

    protected $casts = [
        'tanggal_surat'  => 'date',
        'tanggal_acara'  => 'date',
        'tembusan'       => 'array',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'penandatangan_id');
    }
}
