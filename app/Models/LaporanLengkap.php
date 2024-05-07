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
        'is_validate',
        'attendance',
        'content',
    ];
}
