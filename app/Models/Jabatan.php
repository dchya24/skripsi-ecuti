<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    use HasFactory;
    protected $table = 'jabatan';

    public function rumpunJabatan(){
        return $this->belongsTo(RumpunJabatan::class, 'rumpun_jabatan_id');
    }

    public function subBagian(){
        return $this->belongsTo(SubBagian::class, 'subbagian_id');
    }

    public function user(){
        return $this->hasMany(User::class, 'jabatan_id', "id");
    }
}
