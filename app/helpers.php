<?php

use App\Enums\JenisCuti;
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