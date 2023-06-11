<?php

namespace App\Http\Controllers;

use App\Enums\JenisCuti;
use App\Enums\JenisKelamin;
use App\Enums\StatusCuti;
use App\Http\Requests\AddCutiRequest;
use App\Models\PerizinanCuti;
use App\Service\GlobalService;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index(){
        $perizinanCuti = PerizinanCuti::where('user_id', Auth()->user()->id)->get();

        return $this->view('cuti.index', [
            'riwayat_cuti' => $perizinanCuti
        ],sidebar_menu: "cuti", sidebar_submenu: "cuti.index");
    }

    public function showCreatePage(){
        $user = Auth()->user();
        $catatanCuti = GlobalService::getCutiHistories($user->id);
        
        return $this->view('cuti.add', [
            'catatanCuti' => $catatanCuti,
            'optionsJenisCuti' => JenisCuti::OPTIONS 
        ],sidebar_menu: "cuti", sidebar_submenu: "cuti.add");
    }

    public function addCuti(AddCutiRequest $request){
        $request->validated();
        $jenis_cuti = $request->jenis_cuti;
        $data = $request->all();
        dd($data);
        if($jenis_cuti == JenisCuti::CUTI_BERSALIN && Auth()->user()->jenis_kelamin == JenisKelamin::LAKI_LAKI){
            return "Lu cowo woi";
        }
    }

    public function deleteCuti(Request $request){
        $request->validate([
            "id" => 'required'
        ]);

        $perizinanCuti = PerizinanCuti::findOrFail($request->id);

        if($perizinanCuti->user_id != Auth()->user()->id){
            return abort(403);
        }

        $status_atasan_langsung = $perizinanCuti->status_persetujuan_atasan_langsung;
        $status_pejabat_berwenang = $perizinanCuti->status_keputusan_pejabat_berwenang;
        if($status_atasan_langsung != StatusCuti::PROSES || $status_pejabat_berwenang != null
        || $status_atasan_langsung == null ){
            return redirect()->back()->with("session", [
                'status' => 'danger',
                'message' => "Data Cuti Tidak bisa dihapus!"
            ]);
        }

        $perizinanCuti->delete();

        return redirect()->back()->with("session", [
            'status' => 'success',
            'message' => "Berhasil meghapus data cuti!"
        ]);;
    }
}
