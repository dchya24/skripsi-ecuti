<?php

use App\Enums\JenisCuti;
use App\Enums\RumpunJabatan;
use App\Enums\StatusCuti;

if(!function_exists('getFullName')){
  function getFullName($title_depan, $nama, $title_belakang){
      $gelar_belakang = $title_belakang ? ', ' . $title_belakang : '';
      $fullname = $title_depan . ' ' . $nama . $gelar_belakang;

      return trim($fullname);
  }
}

if(!function_exists('masaKerja')){
  function masaKerja($tmt_masuk){
    $now = date('Y-m-d');

    $date =  date_diff(date_create($now), date_create($tmt_masuk));
    $diff = $date->y . ' Tahun ' . $date->m . ' Bulan ' . $date->d . ' Hari';

    return $diff;
  }
}

if(!function_exists('jenisCuti')){
  function jenisCuti($id){    
    return $id ? JenisCuti::OPTIONS[$id] : null;
  }
}

if(!function_exists('statusCuti')){
  function statusCuti($id){
    return $id ? StatusCuti::OPTIONS[$id] : null;
  }
}

if(!function_exists('isStaff')){
  function isStaff($jabatan){
    if($jabatan->rumpunJabatan->value == RumpunJabatan::STAFF){
      return true;
    }
    return false;
  }
}

if(!function_exists('isPejabatBerwenang')){
  function isPejabatBerwenang($jabatan){
    if(in_array($jabatan->rumpunJabatan->value, [
      RumpunJabatan::ESELON_III,  RumpunJabatan::ESELON_II
    ])){
      return true;
    }
    return false;
  }
}

if(!function_exists('getStatusPerizinanCuti')){
  function getStatusPerizinanCuti($statusAtasan, $statusPejabat){
    $class = StatusCuti::STYLE[$statusAtasan];
    $message = "";

    if($statusAtasan == StatusCuti::PROSES){
      $message = "Sedang diproses oleh Atasan Langsung";
    }
    else if($statusAtasan == StatusCuti::DITANGGUHKAN){
      $message = "Ditangguhkan oleh Atasan Langsung";
    }
    else if($statusAtasan == StatusCuti::TIDAK_DISETUJUI){
      $message = "Ditolak oleh Atasan Langsung";
    }
    else if($statusAtasan == StatusCuti::PERUBAHAN){
      $message = "Perubahan oleh Atasan Langsung";
    }
    else if($statusAtasan == StatusCuti::DISETUJUI){
      $message = "Disetujui oleh Atasan Langsung";
    }

    if($statusPejabat == StatusCuti::PROSES){
      $message = "Sedang diproses oleh Pejabat Berwenang";
      $class = StatusCuti::STYLE[$statusPejabat];
    }
    else if($statusPejabat == StatusCuti::DITANGGUHKAN){
      $class = StatusCuti::STYLE[$statusPejabat];
      $message = "Ditangguhkan oleh Pejabat Berwenang";
    }
    else if($statusPejabat == StatusCuti::TIDAK_DISETUJUI){
      $class = StatusCuti::STYLE[$statusPejabat];
      $message = "Ditolak oleh Pejabat Berwenang";
    }
    else if($statusPejabat == StatusCuti::PERUBAHAN){
      $class = StatusCuti::STYLE[$statusPejabat];
      $message = "Perubahan oleh Pejabat Berwenang";
    }
    else if($statusPejabat == StatusCuti::DISETUJUI){
      $class = StatusCuti::STYLE[$statusPejabat];
      $message = "Disetujui oleh Pejabat Berwenang";
    }

    return [
      'style' => $class,
      'message' => $message
    ];
  }
}