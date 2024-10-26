<?php

namespace App\Models;

use App\Models\Questionnaire\Response;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Peserta extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'peserta';

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'alamat',
        'jurusan',
        'tahun_masuk',
        'email',
        'telepon',
        'jenis_kelamin',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'tanggal_lahir' => 'date:Y-m-d',
    ];

    public function registrations()
    {
        return $this->hasMany(Registrasi::class, 'peserta_id');
    }

    // has One
    public function registrationPlacement()
    {
       
        return $this->hasOne(Registrasi::class, 'peserta_id')
            ->where('status', 'placement');
    }

    public function isKetua()
    {
        return TeamMember::where('ketua_id', $this->id)->exists();
    }

    public function canAddTeamMember()
    {
        if (!$this->isKetua()) {
            return false;
        }

        $registrasiPlacement = $this->registrationPlacement;

        if ($registrasiPlacement) {
            $lowongan = $registrasiPlacement->lowongan;
            return $lowongan && $lowongan->mitra->type === 'Wirausaha Merdeka';
        }

        return false;
    }
    public function responses()
    {
        return $this->hasMany(Response::class, 'peserta_id');
    }
    public function hasCompleteDocuments()
    {
        $requiredDocuments = [
            'surat_rekomendasi' => 'Surat Rekomendasi',
            'transkrip_nilai' => 'Transkrip Nilai',
            'cv' => 'Curriculum Vitae (CV)',
            'pakta_integritas' => 'Pakta Integritas',
            'izin_orangtua' => 'Surat Izin Orangtua',
            'surat_keterangan_sehat' => 'Surat Keterangan Sehat'
        ];
        
        $missingDocuments = [];
        
        foreach ($requiredDocuments as $document => $label) {
            if (!$this->getFirstMediaUrl($document)) {
                $missingDocuments[] = $label;
            }
        }
    
        if (empty($missingDocuments)) {
            return true;
        }
    
        return $missingDocuments;
    }
    
    
}
