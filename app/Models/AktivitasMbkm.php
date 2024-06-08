<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class AktivitasMbkm extends Model
// {
//     use HasFactory;

//     protected $table = 'aktivitas_mbkm';

//     protected $fillable = [
//         'peserta_id',
//         'lowongan_id',
//         'mitra_id',
//         'dospem_id',
//         'laporan_harian_id',
//         'laporan_mingguan_id',
//         'laporan_lengkap_id',
//     ];

//     public function peserta()
//     {
//         return $this->belongsTo(Peserta::class, 'peserta_id');
//     }

//     public function lowongan()
//     {
//         return $this->belongsTo(Lowongan::class, 'lowongan_id');
//     }

//     public function mitra()
//     {
//         return $this->belongsTo(MitraProfile::class, 'mitra_id');
//     }

//     public function dospem()
//     {
//         return $this->belongsTo(DosenPembimbingLapangan::class, 'dospem_id');
//     }

//     public function laporanHarian()
//     {
//         return $this->belongsTo(LaporanHarian::class, 'laporan_harian_id');
//     }

//     public function laporanMingguan()
//     {
//         return $this->belongsTo(LaporanMingguan::class, 'laporan_mingguan_id');
//     }

//     public function laporanLengkap()
//     {
//         return $this->belongsTo(LaporanLengkap::class, 'laporan_lengkap_id');
//     }
// }


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasMbkm extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_mbkm';

    protected $fillable = [
        'peserta_id',
        'lowongan_id',
        'mitra_id',
        'dospem_id',
        'laporan_harian_id',
        'laporan_mingguan_id',
        'laporan_lengkap_id',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }

    public function mitra()
    {
        return $this->belongsTo(MitraProfile::class, 'mitra_id');
    }

    public function dospem()
    {
        return $this->belongsTo(DosenPembimbingLapangan::class, 'dospem_id');
    }

    public function laporanHarian()
    {
        return $this->belongsTo(LaporanHarian::class, 'laporan_harian_id');
    }

    public function laporanMingguan()
    {
        return $this->belongsTo(LaporanMingguan::class, 'laporan_mingguan_id');
    }

    public function laporanLengkap()
    {
        return $this->belongsTo(LaporanLengkap::class, 'laporan_lengkap_id');
    }
}
