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
}
