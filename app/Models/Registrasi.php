<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    use HasFactory;

    protected $table = 'registrasi';

    protected $fillable = [
        'peserta_id',
        'lowongan_id',
        'status',
        'dospem_id',
        'nama_peserta',
        'nama_lowongan',
    ];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    // Registrasi.php
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }

    public function dospem()
    {
        return $this->belongsTo(DosenPembimbingLapangan::class, 'dospem_id');
    }
}
