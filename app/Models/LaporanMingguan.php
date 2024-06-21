<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMingguan extends Model
{
    use HasFactory;

    protected $table = 'laporan_mingguan';
    protected $fillable = [
        'peserta_id',
        'mitra_id',
        'lowongan_id',
        'minggu_ke',
        'isi_laporan',
        'status',
        'kehadiran',
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
