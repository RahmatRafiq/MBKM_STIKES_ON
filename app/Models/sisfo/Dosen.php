<?php

namespace App\Models\sisfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $connection = 'mysql_second';

    protected $table = 'dosen';

    protected $fillable = [
        'id',
        'nip',
        'nama',
        'tanggal_lahir',
        'alamat',
        'departemen',
        'tahun_mulai',
        'email',
    ];
}
