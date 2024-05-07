<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHarian extends Model
{
    use HasFactory;
    protected $fillable = [
        'users_id',
        'is_validate',
        'attendance',
        'content',
    ];
}
