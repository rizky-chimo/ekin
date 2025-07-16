<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Indikator extends Model
{
    protected $fillable = ['instansi_id', 'uraian'];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function rhkStaff()
    {
        return $this->hasMany(RhkStaff::class);
    }

    public function uraianTugas()
    {
        return $this->hasMany(UraianTugas::class);
    }
}