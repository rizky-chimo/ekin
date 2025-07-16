<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable = ['kode', 'nama'];

    public function rhkPejabat()
    {
        return $this->hasMany(RhkPejabat::class);
    }

    public function rhkStaff()
    {
        return $this->hasMany(RhkStaff::class);
    }
}