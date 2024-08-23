<?php

namespace App\Models\sisfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second';
    protected $table = 'mhsw';

    protected $fillable = [
        'MhswID',       // ID Mahasiswa
        'Nama',   
        'Kelamin',      // Kelamin
        'Alamat',       // Alamat
        'telepon',      // Telepon
        'Agama',        // Agama
        'Email',        // Email
        'Login',        // Login
        'LevelID',      // Level ID
        'Password',     // Password
        'NIMSementara', // NIM Sementara
        'KDPIN',        // KDPIN
        'PMBID',        // PMB ID
        'PMBFormJualID' // PMB Form Jual ID
    ];
}
