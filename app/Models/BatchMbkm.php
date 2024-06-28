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
        'is_active',
    ];

    public static function getActiveBatch()
    {
        return self::where('is_active', true)->first();
    }

    public static function isActiveBatchExists()
    {
        $currentDate = \Carbon\Carbon::now();
        return self::where('is_active', true)
            ->where('semester_end', '>=', $currentDate)
            ->exists();
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
