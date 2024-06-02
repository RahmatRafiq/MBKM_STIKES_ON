<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan'; // Sesuaikan nama tabel

    protected $fillable = [
        'id',
        'name',
        'mitra_id',
        'description',
        'quota',
        'is_open',
        'location',
        'gpa',
        'semester',
        'experience_required',
        'start_date',
        'end_date',
    ];

    public function mitra()
    {
        return $this->belongsTo(MitraProfile::class, 'mitra_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registrasi::class, 'lowongan_id');
    }
}
