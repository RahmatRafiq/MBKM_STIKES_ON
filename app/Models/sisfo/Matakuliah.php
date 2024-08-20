<?php

namespace App\Models\sisfo;

use App\Models\Lowongan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second'; // Mengambil data dari database mysql_second
    protected $table = 'mk';
    protected $primaryKey = 'MKID'; // Tambahkan ini jika kunci utama tabel adalah MKID

    protected $fillable = [
        'MKID',
        'KodeID',
        'Nama',
        'SKS',
        'MKKode',
    ];

    public function lowongans()
    {
        return $this->belongsToMany(Lowongan::class, 'lowongan_has_matakuliah', 'matakuliah_id', 'lowongan_id');
    }
}
