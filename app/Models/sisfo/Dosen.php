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
        'Login',         // Login
        'KodeID',        // KodeID
        'NIDN',          // NIDN
        'HomebaseInduk', // HomebaseInduk
        'NIPPNS',        // NIPPNS
        'Nama',          // Nama
        'TempatLahir',   // TempatLahir
        'TanggalLahir',  // TanggalLahir
        'LevelID',       // LevelID
        'KTP',           // KTP
    ];
}
