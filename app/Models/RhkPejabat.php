<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class RhkPejabat extends Model
{
    protected $fillable = ['jabatan_id', 'instansi_id', 'uraian'];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}