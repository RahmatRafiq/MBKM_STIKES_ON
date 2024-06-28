<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchMbkm extends Model
{
    use HasFactory;

    protected $table = 'batch_mbkms';

    protected $fillable = [
        'id',
        'name',
        'semester_start',
        'semester_end',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
