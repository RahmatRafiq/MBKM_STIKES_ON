<?php

namespace App\Models\RolePermission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleController extends \Spatie\Permission\Models\Role
{
    // use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'guard_name',
    // ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

}
