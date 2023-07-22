<?php

namespace App\Http\Controllers;

use App\Models\CatatanCuti;
use App\Models\Jabatan;
use App\Models\User;
use App\Service\GlobalService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboardPage(){
        $user = Auth()->user();
        $dataJabatan = GlobalService::getAtasanPejabat($user->jabatan_id);
        // dd($dataJabatan);

        $catatanCuti = GlobalService::getCutiHistories($user->id);

        $atasanLangsung = $dataJabatan['atasan_langsung'] ? $dataJabatan['atasan_langsung'] : null; 
        $pejabatBerwenang = $dataJabatan['pejabat_berwenang'] ? $dataJabatan['pejabat_berwenang'] : null;

        return $this->view('dashboard', [
            'atasanLangsung' => $atasanLangsung,
            'pejabatBerwenang' => $pejabatBerwenang,
            'catatanCuti' => $catatanCuti
        ], sidebar_menu: "dashboard");
    }

    public function profilePage(){
        $data = Auth::user();
        $catatanCuti = GlobalService::getCutiHistories($data->id);

        return $this->view('profile', [
            'data' => $data, 
            'catatanCuti' => $catatanCuti
        ], sidebar_menu: "dashboard");
    }

    public function changePassword(Request $request){
        $password = $request->password;
        $confirm_password = $request->confirm_password;

        if($password !== $confirm_password){
            return redirect()->back()->with("session", [
                'status' => 'danger',
                'message' => "Password Tidak Sama!"
            ]);
        }

        $hashPassword = bcrypt($password);

        $user = User::find(Auth::user()->id);
        $user->password = $hashPassword;
        $user->save();

        if(!$user){
            return redirect()->back()->with("session", [
                'status' => 'danger',
                'message' => "Terjadi kesalahan!"
            ]);
        }

        return redirect()->back()->with("session", [
            'status' => 'success',
            'message' => "Password pegawai berhasil diubah!"
        ]);
    }
}
