<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RhkStaff extends Model
{
    protected $fillable = ['jabatan_id', 'indikator_id', 'instansi_id', 'uraian', 'nilai', 'tahun'];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class);
    }

    public function uraianTugas()
    {
        return $this->hasMany(UraianTugas::class);
    }
}