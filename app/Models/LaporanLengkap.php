<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class LaporanLengkap extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'laporan_lengkap';
    protected $fillable = [
        'peserta_id',
        'mitra_id',
        'dospem_id',
        'isi_laporan',
        'status',
        'feedback',
        'batch_id',
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
    
    public static function getByUser($user, $pesertaId = null, $batchId = null)
    {
        $query = self::with(['peserta', 'dospem'])
            ->whereHas('dospem', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });

        if ($pesertaId) {
            $query->where('peserta_id', $pesertaId);
        }
        return $query->get();
    }
}
