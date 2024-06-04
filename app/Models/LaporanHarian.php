<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// class LaporanHarian extends Model
// {
//     use HasFactory;
//     protected $fillable = [
//         'users_id',
//         'is_validate',
//         'attendance',
//         'content',
//     ];
// }
class LaporanHarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'peserta_id',
        'mitra_id', // Tambahkan mitra_id di sini
        'tanggal',
        'isi_laporan',
        'status',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
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