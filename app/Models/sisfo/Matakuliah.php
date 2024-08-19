<?php

namespace App\Models\sisfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second';
    protected $table = 'mk';

    protected $fillable = [
        'MKID',         // ID Matakuliah
        'Kode',         // Kode
        'Nama',         // Nama
        'SKS',     
        'MKKode',
    ];
}