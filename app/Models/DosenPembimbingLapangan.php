<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbingLapangan extends Model
{
    use HasFactory;

    protected $table = 'dosen_pembimbing_lapangan';
    protected $fillable = [
        'user_id',
        'name',
        'image',
        'address',
        'phone',
        'email',
        'nip',
    ];
}



