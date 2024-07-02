<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProgram extends Model
{
    use HasFactory;

    protected $table = 'type_programs';

    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function typeProgram()
    {
        return $this->belongsTo(TypeProgram::class, 'type_id');
    }

}
