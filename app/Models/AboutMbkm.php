<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutMbkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'description',
        'duration',
        'eligibility',
        'benefits',
        'contact_email',
        'contact_phone',
        'contact_address',
    ];


    protected $casts = [
        'benefits' => 'array',
        'eligibility' => 'array',
    ];
}
