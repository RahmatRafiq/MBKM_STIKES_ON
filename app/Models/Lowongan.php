<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
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
        return $this->belongsTo(MitraProfile::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
