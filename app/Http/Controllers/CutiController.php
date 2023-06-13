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
            'riwayat_cuti' => $perizinanCuti,
            'optionsJenisCuti' => JenisCuti::OPTIONS,
            'statusCutiOptions' => StatusCuti::OPTIONS
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
        $user = Auth()->user();
        $request->validated();
        $jenis_cuti = $request->jenis_cuti;
        $data = $request->except(['_token']);
        $data['alamat_menjalankan_cuti'] = $data['alamat'];

        $atasan = GlobalService::getAtasanPejabat($user->jabatan_id);
        $data['atasan_langsung_id'] = $atasan['atasan_langsung']->id;
        $data['pejabat_berwenang_id'] = $atasan['pejabat_berwenang']->id;
        $data['akhir_cuti'] = date_create($data['akhir_cuti']);
        $data['mulai_cuti'] = date_create($data['mulai_cuti']);

        $dateDiff = date_diff(($data['akhir_cuti']), ($data['mulai_cuti']));
        $dayDiff = $dateDiff->days + 1;
        if($dayDiff != $data['jumlah_hari']){
            return redirect()->back()->with("session", [
                'status' => 'danger',
                'message' => "Data Cuti Tidak Sinkron!"
            ]);
        }
        
        if($jenis_cuti == JenisCuti::CUTI_BERSALIN){
            if(Auth()->user()->jenis_kelamin == JenisKelamin::LAKI_LAKI){
                return redirect()->back()->with("session", [
                    'status' => 'danger',
                    'message' => "Cuti Bersalin hanya untuk perempuan!"
                ]);
            }
        }
        else if($jenis_cuti == JenisCuti::CUTI_TAHUNAN){
            $sisa = GlobalService::getCountSisaCutiTahunan($user->id);
            if($data['jumlah_hari'] > $sisa){
                return redirect()->back()->with("session", [
                    'status' => 'danger',
                    'message' => "Lama hari cuti melebihi sisa cuti yang bisa dipakai!"
                ]);
            }
        }

        $data['status_persetujuan_atasan_langsung'] = StatusCuti::PROSES;
        $data['user_id'] = $user->id;
        $perizinanCuti = PerizinanCuti::create($data);

        return redirect()->back()->with("session", [
            'status' => 'success',
            'message' => "Berhasil Mengajukan Permohonan cuti!"
        ]);
    }

    public function show($id){
        $data = PerizinanCuti::with(['user', 'user.jabatan', 'atasanLangsung', 'pejabatBerwenang'])
            ->where('id', $id)
            ->first();

        $catatanCuti = GlobalService::getCutiHistories($data->user->id);

        return $this->view('cuti.detail', [
            'data' => $data,
            'catatanCuti' => $catatanCuti,
            'optionsJenisCuti' => JenisCuti::OPTIONS,
            'statusCutiOptions' => StatusCuti::OPTIONS
        ], sidebar_menu: 'approval', sidebar_submenu: 'approval.atasan');
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
        if($status_atasan_langsung != StatusCuti::PROSES && $status_pejabat_berwenang != null
        && $status_atasan_langsung == null ){
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
