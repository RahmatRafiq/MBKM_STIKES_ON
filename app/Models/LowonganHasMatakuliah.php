<?php

namespace App\Models;

use App\Models\sisfo\Matakuliah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganHasMatakuliah extends Model
{
    use HasFactory;

    protected $table = 'lowongan_has_matakuliah';
    protected $fillable = [
        'lowongan_id',
        'matakuliah_id',
    ];

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }
}
