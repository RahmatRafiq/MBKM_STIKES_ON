<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraProfile extends Model
{
    use HasFactory;

    protected $table = 'mitra_profile';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'image',
        'type',
        'description',
    ];
}
