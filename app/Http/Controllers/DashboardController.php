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
 
        // }

        $catatanCuti = GlobalService::getCutiHistories($user->id);
        $atasanLangsung = $dataJabatan['atasan_langsung'] ? $dataJabatan['atasan_langsung'] : null; 
        $pejabatBerwenang = $dataJabatan['pejabat_berwenang'] ? $dataJabatan['pejabat_berwenang'] : null;

        return $this->view('dashboard', [
            'atasanLangsung' => $atasanLangsung,
            'pejabatBerwenang' => $pejabatBerwenang,
            'catatanCuti' => $catatanCuti
        ], sidebar_menu: "dashboard");
    }
}
