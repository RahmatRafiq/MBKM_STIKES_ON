<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbingLapangan extends Model
{
    use HasFactory;

    protected $table = 'dosen_pembimbing_lapangan';
    protected $fillable = [
        'name',
        'image',
        'address',
        'phone',
        'email',
        'nip',
    ];

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'roles_id', 'id');
    }
}



