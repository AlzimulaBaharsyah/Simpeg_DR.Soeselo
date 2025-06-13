<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ijinbelajar extends Model
{
    /** @use HasFactory<\Database\Factories\IjinbelajarFactory> */
    use HasFactory;

    protected $table = 'ijinbelajars';
    protected $guarded = [];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
