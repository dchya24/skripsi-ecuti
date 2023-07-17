<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'nip',
        'nik',
        'gelar_depan',
        'gelar_belakang',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'tmt_masuk',
        'alamat',
        "jabatan_id",
        'no_telp'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute(){
        $gelar_belakang = $this->gelar_belakang ? ', ' . $this->gelar_belakang : '';
        $fullname = $this->gelar_depan . ' ' . $this->nama . $gelar_belakang;

        return trim($fullname);
    }

    public function jabatan(){
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function riwayatCuti(){
        return $this->hasMany(PerizinanCuti::class, 'user_id');
    }
    
    public function persetujuanAtasan(){
        return $this->hasMany(PerizinanCuti::class, 'atasan_langsung_id');
    }
    
    public function keputusanPejabat(){
        return $this->hasMany(PerizinanCuti::class, 'pejabat_berwenang_id');
    }
}
