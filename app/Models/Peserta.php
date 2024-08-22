<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Peserta extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'peserta';

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'alamat',
        'jurusan',
        'tahun_masuk',
        'email',
        'telepon',
        'jenis_kelamin',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'tanggal_lahir' => 'date:Y-m-d',
    ];

    public function registrations()
    {
        return $this->hasMany(Registrasi::class, 'peserta_id');
    }

    // has One
    public function registrationPlacement()
    {
        $semesterStart = env('SEMESTER_START');
        $semesterEnd = env('SEMESTER_END');
        return $this->hasOne(Registrasi::class, 'peserta_id')
            ->where('status', 'placement')
            ->whereDate('registrasi.created_at', '>=', $semesterStart)
            ->whereDate('registrasi.created_at', '<=', $semesterEnd);
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('surat_rekomendasi')
            ->singleFile();

        $this
            ->addMediaCollection('transkrip_nilai')
            ->singleFile();

        $this
            ->addMediaCollection('cv')
            ->singleFile();

        $this
            ->addMediaCollection('pakta_integritas')
            ->singleFile();

        $this
            ->addMediaCollection('izin_orangtua')
            ->singleFile();

        $this
            ->addMediaCollection('surat_keterangan_sehat')
            ->singleFile();
    }
}
