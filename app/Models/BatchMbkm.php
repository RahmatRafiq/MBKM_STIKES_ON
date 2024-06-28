<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchMbkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'semester_start',
        'semester_end',
    ];
}
