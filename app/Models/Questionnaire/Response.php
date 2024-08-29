<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Peserta;

class Response extends Model
{
    use HasFactory;

    protected $fillable = ['peserta_id'];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function details()
    {
        return $this->hasMany(ResponseDetail::class);
    }
}
