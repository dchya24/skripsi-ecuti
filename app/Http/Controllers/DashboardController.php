<?php

namespace App\Http\Controllers;

use App\Models\CatatanCuti;
use App\Models\jabatan;
use App\Models\User;
use App\Service\GlobalService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboardPage(){
        $user = Auth()->user();
        $dataJabatan = GlobalService::getAtasanPejabat($user->jabatan_id);
        // $jabatan = $user->jabatan;
        // $rumpun = $jabatan->rumpunJabatan;

        // $jabatanAtasan = jabatan::where('subbagian_id', $jabatan->subbagian_id)
        //             ->whereHas('rumpunJabatan', function(Builder $query) use ($rumpun) {
        //                 $query->where('value', $rumpun->value - 1);
        //             })
        //             ->first();

        // if($rumpun->value == 4){
        //     $jabatan = DB::table('users as pb')
        //     ->select('pb.id as user_id')
        //     ->join('jabatan as j', 'j.id', '=', 'pb.jabatan_id')
        //     ->join('rumpun_jabatan as rj', 'rj.id', '=', 'j.rumpun_jabatan_id')
        //     ->where('rj.value', '2')
        //     ->where('j.nama', 'Sekretaris Dinas')
        //     ->first();

        //     $pejabat = User::find($jabatan->user_id);
        // }

        $catatanCuti = GlobalService::getCutiHistories($user->id);

        return $this->view('dashboard', [
            'atasanLangsung' => $dataJabatan['atasan_langsung']->user[0],
            'pejabatBerwenang' => $dataJabatan['pejabat_berwenang'],
            'catatanCuti' => $catatanCuti
        ], sidebar_menu: "dashboard");
    }
}
