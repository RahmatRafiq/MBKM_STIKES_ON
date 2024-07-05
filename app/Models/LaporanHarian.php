<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class LaporanHarian extends Model
{
    use HasFactory;

    protected $table = 'laporan_harian';
    protected $fillable = [
        'peserta_id',
        'mitra_id',
        'dospem_id',
        'tanggal',
        'isi_laporan',
        'status',
        'kehadiran',
        'feedback',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function mitra()
    {
        return $this->belongsTo(MitraProfile::class);
    }

    public function dospem()
    {
        return $this->belongsTo(DosenPembimbingLapangan::class, 'dospem_id', 'id');
    }

    // public function lowongan()
    // {
    //     return $this->belongsTo(Lowongan::class);
    // }

    public function lowongan()
    {
        return $this->hasOneThrough(
            Lowongan::class,
            MitraProfile::class,
            'id', // Foreign key on MitraProfile table
            'mitra_id', // Foreign key on Lowongan table
            'mitra_id', // Local key on LaporanHarian table
            'id' // Local key on MitraProfile table
        );
    }
    
    public function laporanMingguan()
    {
        $semesterStart = \Carbon\Carbon::parse(env('SEMESTER_START'));
        return $this->belongsTo(LaporanMingguan::class, 'peserta_id', 'peserta_id')
                    ->whereRaw('WEEKOFYEAR(laporan_harian.tanggal) - WEEKOFYEAR(?) + 1 = laporan_mingguan.minggu_ke', [$semesterStart]);
    }
    public static function getByUser($user, $pesertaId = null)
    {
        $query = self::with(['peserta', 'mitra'])
            ->whereHas('mitra', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });

        if ($pesertaId) {
            $query->where('peserta_id', $pesertaId);
        }

        return $query->get();
    }
}