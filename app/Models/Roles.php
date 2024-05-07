<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = [
        'name',
    ];
    public function dosen_pembimbing_lapangan()
    {
        return $this->hasMany(DosenPembimbingLapangan::class, 'roles_id', 'id');
    }
}

