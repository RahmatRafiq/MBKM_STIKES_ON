<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanLengkap extends Model
{
    use HasFactory;

    protected $table = 'laporan_lengkap';
    protected $fillable = [
        'peserta_id',
        'dospem_id',
        'mitra_id', // Tambahkan mitra_id di sini
        'isi_laporan',
        'status',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function dospem()
    {
        return $this->belongsTo(DosenPembimbingLapangan::class);
    }

    public function mitra()
    {
        return $this->belongsTo(MitraProfile::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }
}
