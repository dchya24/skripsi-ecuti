<?php
namespace App\Enums;

class JenisCuti
{
    const KEY = 'rumpun-jabatan';

    const CUTI_TAHUNAN = 1,
          CUTI_SAKIT = 2,
          CUTI_BESAR = 3,
          CUTI_BERSALIN = 4,
          CUTI_ALASAN_PENTING = 5,
          CUTI_DILUAR_TANGGUNGAN_NEGARA = 6;
    
    const array = [
      "CUTI_TAHUNAN" => 1,
      "CUTI_SAKIT" => 2,
      "CUTI_BESAR" => 3,
      "CUTI_BERSALIN" => 4,
      "CUTI_ALASAN_PENTING" => 5,
      "CUTI_DILUAR_TANGGUNGAN_NEGARA" => 6
    ];
    
    const OPTIONS = [
      1 => "Cuti Tahunan",
      2 => "Cuti Sakit",
      3 => "Cuti Besar",
      4 => "Cuti Melahirkan",
      5 => "Cuti Alasan Penting",
      6 => "Cuti Diluar Tanggungan Negara"
    ];
}
