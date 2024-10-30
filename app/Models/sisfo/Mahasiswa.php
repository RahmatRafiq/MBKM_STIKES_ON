<?php

namespace App\Models\sisfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second';
    protected $table = 'mhsw';

    protected $fillable = [
        'MhswID', // ID Mahasiswa
        'Nama',
        'Kelamin', // Kelamin
        'Alamat', // Alamat
        'telepon', // Telepon
        'Agama', // Agama
        'Email', // Email
        'Login', // Login
        'LevelID', // Level ID
        'Password', // Password
        'NIMSementara', // NIM Sementara
        'KDPIN', // KDPIN
        'PMBID', // PMB ID
        'PMBFormJualID', // PMB Form Jual ID
    ];

    public static function getEligibleMahasiswa($search = null)
    {
        $query = self::query()
            ->whereNotNull('mhsw.Email')
            ->where('mhsw.Email', '!=', '')
            ->where('mhsw.Email', 'LIKE', '%@%')
            ->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('siakad.khs')
                    ->whereColumn('siakad.khs.MhswID', 'mhsw.Login')
                    ->where('siakad.khs.StatusMhswID', 'A')
                    ->where('siakad.khs.Sesi', '>', 3)
                    ->where(function ($query) {
                        $query->where('siakad.khs.IP', '>', 2.50)
                            ->orWhere('siakad.khs.IPS', '>', 2.50);
                    })
                    ->whereRaw('siakad.khs.Sesi = (SELECT MAX(Sesi) FROM siakad.khs WHERE MhswID = mhsw.Login)');
            })
            ->leftJoin('siakad.khs as k', function ($join) {
                $join->on('k.MhswID', '=', 'mhsw.Login')
                    ->where('k.StatusMhswID', 'A')
                    ->where('k.Sesi', '>', 3)
                    ->where(function ($query) {
                        $query->where('k.IP', '>', 2.50)
                            ->orWhere('k.IPS', '>', 2.50);
                    })
                    ->whereRaw('k.Sesi = (SELECT MAX(Sesi) FROM siakad.khs WHERE MhswID = mhsw.Login)');
            })
            ->select('mhsw.*', 'k.Sesi')
            ->orderBy('mhsw.Nama', 'asc'); // Mengurutkan berdasarkan Nama, bisa disesuaikan

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('mhsw.Nama', 'LIKE', '%' . $search . '%')
                    ->orWhere('mhsw.MhswID', 'LIKE', '%' . $search . '%')
                    ->orWhere('mhsw.Email', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->get();
    }

}
