<?php
namespace App\Service;

use App\Enums\RumpunJabatan;
use App\Models\CatatanCuti;
use App\Models\jabatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\Builder;

class GlobalService {
  public static function getCutiHistories($user_id){
    $catatanCuti = CatatanCuti::where('user_id', $user_id)
            ->orderBy('tahun', 'desc')->limit(3)->get();

    return $catatanCuti;
  }

  public static function getCountSisaCutiTahunan($user_id){
    $catatanCuti = self::getCutiHistories($user_id);
    $sisa = 0;
    foreach ($catatanCuti as $item) {
      $sisa += $item->sisa_cuti_tahunan;
    }

    return $sisa;
  }

  public static function getAtasanPejabat($jabatan_id){
      $jabatan = Jabatan::find($jabatan_id);
      $rumpun = $jabatan->rumpunJabatan;

      $rumpunEselonIV = [
        RumpunJabatan::JFT_SUBKOORDINATOR,
        $rumpun->value == RumpunJabatan::ESELON_IV
      ];

      $jabatanAtasan = [];
      $pejabat = [];
      if($rumpun->value == RumpunJabatan::STAFF){
        $pejabat = self::baseQuery()
        ->where('rj.value', '2')
        ->where('j.nama', 'Sekretaris Dinas')
        ->first();
        $jabatanAtasan = $jabatanAtasan = self::queryAtasanLangsung()
        ->where('rj.value', $rumpun->value -1)
        ->where('sb.id', $jabatan->subbagian_id)
        ->first();
      }
      else if(in_array($rumpun->value, $rumpunEselonIV)){
        $pejabat = self::baseQuery()
        ->where('rj.value', '1')
        ->where('j.nama', 'Kepala Dinas')
        ->first();

        $jabatanAtasan = self::queryAtasanLangsung()
          ->where('rj.value', $rumpun->value -1)
          ->where('b.id', $jabatan->subbagian->bagian_id)
          ->first();
      }

      return [
        'atasan_langsung' => $jabatanAtasan,
        'pejabat_berwenang' => $pejabat
      ];
  }

  private static function baseQuery(){
    return $jabatan = DB::table('users as pb')
    ->select(DB::raw('
      pb.id as id,
      pb.nama as nama, 
      pb.gelar_depan as gelar_depan, 
      pb.gelar_belakang as gelar_belakang,
      j.nama as jabatan,
      rj.nama as rumpun_jabatan,
      rj.value as rumpun_value'
    ))
    ->join('jabatan as j', 'j.id', '=', 'pb.jabatan_id')
    ->join('sub_bagian as sb', 'sb.id', '=', 'j.subbagian_id')
    ->join('rumpun_jabatan as rj', 'rj.id', '=', 'j.rumpun_jabatan_id');
  }

  private static function queryAtasanLangsung(){
    return $jabatan = DB::table('users as pb')
    ->select(DB::raw('
      pb.id as id,
      pb.nama as nama, 
      pb.gelar_depan as gelar_depan, 
      pb.gelar_belakang as gelar_belakang,
      j.nama as jabatan,
      rj.nama as rumpun_jabatan,
      rj.value as rumpun_value'
    ))
    ->join('jabatan as j', 'j.id', '=', 'pb.jabatan_id')
    ->join('sub_bagian as sb', 'sb.id', '=', 'j.subbagian_id')
    ->join('bagian as b', 'b.id', 'sb.bagian_id')
    ->join('rumpun_jabatan as rj', 'rj.id', '=', 'j.rumpun_jabatan_id');
  }

}