<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbingLapangan extends Model
{
    use HasFactory;

    protected $table = 'dosen_pembimbing_lapangan';
    protected $fillable = [
        'users_id',
        'roles_id',
        'name',
        'image'
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'roles_id', 'id');
    }
}



