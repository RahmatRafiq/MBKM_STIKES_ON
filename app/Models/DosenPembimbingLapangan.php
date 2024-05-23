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

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];  
}



