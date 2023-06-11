<?php
namespace App\Service;

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

  public static function getAtasanPejabat($jabatan_id){
      $jabatan = Jabatan::find($jabatan_id);
      $rumpun = $jabatan->rumpunJabatan;
      $jabatanAtasan = jabatan::where('subbagian_id', $jabatan->subbagian_id)
                  ->whereHas('rumpunJabatan', function(Builder $query) use ($rumpun) {
                      $query->where('value', $rumpun->value - 1);
                  })
                  ->first();

      $pejabat = [];
      if($rumpun->value == 4){
        $pejabat = self::baseQuery()
        ->where('rj.value', '2')
        ->where('j.nama', 'Sekretaris Dinas')
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
      pb.nama as nama, 
      pb.gelar_depan as gelar_depan, 
      pb.gelar_belakang as gelar_belakang,
      j.nama as jabatan,
      rj.nama as rumpun_jabatan,
      rj.value as rumpun_value'
    ))
    ->join('jabatan as j', 'j.id', '=', 'pb.jabatan_id')
    ->join('rumpun_jabatan as rj', 'rj.id', '=', 'j.rumpun_jabatan_id');
  }
}