<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('skpd');
            $table->string('unit_kerja');
            $table->string('nama_jabatan');
            $table->string('formasi_jabatan')->nullable();
            $table->string('formasi_jabatan_tingkat')->nullable();
            $table->string('formasi_jabatan_keterangan')->nullable();
            $table->string('jenis_kepegawaian')->nullable();
            $table->string('jenis_jabatan')->nullable();
            $table->string('status')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('golongan_ruang')->nullable();
            $table->date('tmt_golongan_ruang')->nullable();
            $table->string('golongan_ruang_cpns')->nullable();
            $table->date('tmt_golongan_ruang_cpns')->nullable();
            $table->date('tmt_pns')->nullable();
            $table->string('eselon')->nullable();
            $table->date('tmt_jabatan')->nullable();
            $table->string('sk_pengangkatan_blud')->nullable();
            $table->date('tgl_sk_pengangkatan_blud')->nullable();
            $table->string('mou_awal_blud')->nullable();
            $table->date('tgl_mou_awal_blud')->nullable();
            $table->date('tmt_awal_mou_blud')->nullable();
            $table->date('tmt_akhir_mou_blud')->nullable();
            $table->string('mou_akhir_blud')->nullable();
            $table->date('tgl_akhir_blud')->nullable();
            $table->date('tmt_mou_akhir')->nullable();
            $table->date('tmt_akhir_mou')->nullable();
            $table->string('no_mou_mitra')->nullable();
            $table->date('tgl_mou_mitra')->nullable();
            $table->date('tmt_mou_mitra')->nullable();
            $table->date('tmt_akhir_mou_mitra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatans');
    }
};
