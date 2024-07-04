<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MitraProfile extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'mitra_profile';
    protected $fillable = [
        'name',
        'user_id',
        'address',
        'phone',
        'email',
        'website',
        'type',
        'description',
    ];
    public function lowongan()
    {
        return $this->hasMany(Lowongan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getLowongan()
    {
        return $this->hasMany(Lowongan::class, 'mitra_id');
    }
}
