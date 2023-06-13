<?php

namespace App\Http\Controllers;

use App\Enums\JenisCuti;
use App\Enums\StatusCuti;
use App\Models\CatatanCuti;
use App\Models\PerizinanCuti;
use App\Service\GlobalService;
use Illuminate\Http\Request;

class ApprovalCutiController extends Controller
{
    public function index(){
        $data = PerizinanCuti::with(['user', 'user.jabatan', 'atasanLangsung', 'pejabatBerwenang'])
            ->where('status_persetujuan_atasan_langsung', StatusCuti::PROSES)
            ->where('status_keputusan_pejabat_berwenang', null)
            ->get();

        return $this->view('atasan-approval.index', [
            'data' => $data,
            'optionsJenisCuti' => JenisCuti::OPTIONS,
            'statusCutiOptions' => StatusCuti::OPTIONS
        ], sidebar_menu: 'approval', sidebar_submenu: 'approval.atasan');
    }

    public function showApproval($id){
        $data = PerizinanCuti::with(['user', 'user.jabatan', 'atasanLangsung', 'pejabatBerwenang'])
            ->where('id', $id)
            ->first();

        $catatanCuti = GlobalService::getCutiHistories($data->user->id);

        return $this->view('atasan-approval.detail', [
            'data' => $data,
            'catatanCuti' => $catatanCuti,
            'optionsJenisCuti' => JenisCuti::OPTIONS,
            'statusCutiOptions' => StatusCuti::OPTIONS
        ], sidebar_menu: 'approval', sidebar_submenu: 'approval.atasan');
    }

    public function approveCuti(Request $request){
        $status = $request->status;
        $alasan_pertimbangan = $request->alasan_pertimbangan;

        $perizinan = PerizinanCuti::find($request->_id);

        $perizinan->status_persetujuan_atasan_langsung = $status;
        $perizinan->alasan_persetujuan_atasan_langsung = $alasan_pertimbangan;

        if($status == StatusCuti::DISETUJUI){
            $perizinan->status_keputusan_pejabat_berwenang = StatusCuti::PROSES;
        }

        $perizinan->save();

        return redirect()->back()->with('success', 'Berhasil memberikan pertimbangan cuti pegawai!');
    }
}
