<?php
namespace App\Enums;

class StatusPertimbanganCuti
{
    const KEY = 'rumpun-jabatan';

    const DISETUJUI = 1,
          PERUBAHAN = 2,
          DITANGGUHKAN = 3,
          TIDAK_DISETUJUI = 4;
    
    const OPTIONS = [
      1 => "Disetujui",
      2 => "Perubahan",
      3 => "Ditangguhkan",
      4 => "Tidak Disetujui"
    ];
}
