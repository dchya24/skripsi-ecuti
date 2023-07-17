<?php

namespace App\Http\Controllers;

use App\Enums\JenisCuti;
use App\Enums\StatusCuti;
use App\Models\CatatanCuti;
use App\Models\PerizinanCuti;
use App\Service\GlobalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalCutiController extends Controller
{
    public function index(Request $request){
        $data = PerizinanCuti::with(['user', 'user.jabatan', 'atasanLangsung', 'pejabatBerwenang'])
            // ->where('status_persetujuan_atasan_langsung', StatusCuti::PROSES)
            // ->whereIn('status_keputusan_pejabat_berwenang', [null, StatusCuti::PROSES])
            ->where('atasan_langsung_id', Auth::user()->id)
            ->where('user_id', '!=', null);

        $filterStatus = $request->query('status_atasan');
        $filterJenisCuti = $request->query('jenis_cuti');

        if(!empty($filterStatus) && $filterStatus !== 'all'){
            $data = $data->where('status_persetujuan_atasan_langsung', $filterStatus);
        }

        if(!empty($filterJenisCuti) && $filterJenisCuti !== 'all'){
            $data = $data->where('jenis_cuti_id', $filterJenisCuti);
        }

        // dd($data->getQuery());
        $data = $data->orderBy('created_at', 'desc')->paginate(10);

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

        if($perizinan->status_keputusan_pejabat_berwenang != null && $perizinan->status_keputusan_pejabat_berwenang != StatusCuti::PROSES){
            return redirect()->back()->with("session", [
                'status' => 'danger',
                'message' => "Perizinan Cuti Pegawai Sudah diberi keputusan oleh Pejabat Berwenang!"
            ]);
        }

        $perizinan->status_persetujuan_atasan_langsung = $status;
        $perizinan->alasan_persetujuan_atasan_langsung = $alasan_pertimbangan;

        if($status == StatusCuti::DISETUJUI){
            $perizinan->status_keputusan_pejabat_berwenang = StatusCuti::PROSES;
        }

        $perizinan->save();

        // return redirect()->back()->with('success', 'Berhasil memberikan pertimbangan cuti pegawai!');
        return redirect()->back()->with("session", [
            'status' => 'success',
            'message' => "Berhasil memberikan pertimbangan cuti pegawai!"
        ]);
    }
}
