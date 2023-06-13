<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerizinanCuti extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "perizinan_cuti";
    protected $fillable = [
        "jenis_cuti_id",
        "alasan_cuti",
        "bukti",
        "mulai_cuti",
        "akhir_cuti",
        "jumlah_hari",
        "alamat_menjalankan_cuti",
        "no_telp",
        "atasan_langsung_id",
        "pejabat_berwenang_id"
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function atasanLangsung(){
        return $this->belongsTo(User::class, 'atasan_langsung_id');
    }

    public function pejabatBerwenang(){
        return $this->belongsTo(User::class, 'pejabat_berwenang_id');
    }
}
