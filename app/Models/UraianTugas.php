<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UraianTugas extends Model
{
    protected $fillable = ['indikator_id', 'rhk_staff_id', 'instansi_id', 'uraian'];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class);
    }

    public function rhkStaff()
    {
        return $this->belongsTo(RhkStaff::class);
    }
}