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
        'mitra_id', // Tambahkan mitra_id di sini
        'tanggal',
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