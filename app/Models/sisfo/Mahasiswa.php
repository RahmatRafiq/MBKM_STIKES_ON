<?php

namespace App\Models\sisfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second';

    protected $table = 'mahasiswa';
    protected $fillable = [
        'nim',
        'nama',
        'alamat',
        'jurusan',
        'tahun_masuk',
        'email',
        'telepon',
        'jenis_kelamin',
    ];
}
