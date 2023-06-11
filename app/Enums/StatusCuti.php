<?php
namespace App\Enums;

class StatusCuti
{
    const KEY = 'rumpun-jabatan';

    const PROSES = 99,
          DISETUJUI = 1,
          PERUBAHAN = 2,
          DITANGGUHKAN = 3,
          TIDAK_DISETUJUI = 4;
    
    const OPTIONS = [
      99 => "Proses",
      1 => "Disetujui",
      2 => "Perubahan",
      3 => "Ditangguhkan",
      4 => "Tidak Disetujui"
    ];
    
    const STYLE = [
      99 => "secondary",
      1 => "success",
      2 => "info",
      3 => "danger",
      4 => "warning"
    ];
}
