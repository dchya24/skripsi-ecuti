<?php

namespace App\Http\Controllers;

use App\Enums\JenisCuti;
use App\Enums\StatusCuti;
use App\Models\CatatanCuti;
use App\Models\PerizinanCuti;
use App\Service\GlobalService;
use Illuminate\Http\Request;


class PejabatBerwenangController extends Controller
{
    public function index(Request $request){
        $data = PerizinanCuti::with(['user', 'user.jabatan', 'atasanLangsung', 'pejabatBerwenang'])
            ->where('status_persetujuan_atasan_langsung', StatusCuti::DISETUJUI);
            // ->where('status_keputusan_pejabat_berwenang', StatusCuti::PROSES)

        $filterStatus = $request->query('status_pejabat');
        $filterJenisCuti = $request->query('jenis_cuti');

        if($filterStatus){
            $data->where('status_keputusan_pejabat_berwenang', $filterStatus);
        }

        if($filterJenisCuti){
            $data->where('jenis_cuti_id', $filterJenisCuti);
        }

        $riwayat = $data->paginate(5);
        return $this->view('pejabat-keputusan.index', [
            'data' => $riwayat,
            'optionsJenisCuti' => JenisCuti::OPTIONS,
            'statusCutiOptions' => StatusCuti::OPTIONS
        ], sidebar_menu: 'approval', sidebar_submenu: 'approval.pejabat');
    }

    public function show($id){
        $data = PerizinanCuti::with(['user', 'user.jabatan', 'atasanLangsung', 'pejabatBerwenang'])
            ->where('id', $id)
            ->first();

        $catatanCuti = GlobalService::getCutiHistories($data->user->id);

        return $this->view('pejabat-keputusan.detail', [
            'data' => $data,
            'catatanCuti' => $catatanCuti,
            'optionsJenisCuti' => JenisCuti::OPTIONS,
            'statusCutiOptions' => StatusCuti::OPTIONS
        ], sidebar_menu: 'approval', sidebar_submenu: 'approval.atasan');
    }

    public function keputusanCuti(Request $request){
        $data = [
            "status_keputusan_pejabat_berwenang" => $request->status,
            "alasan_keputusan_pejabat_berwenang" => $request->alasan_keputusan
        ];

        $result = true;
        if($request->status == StatusCuti::DISETUJUI){
            $cuti = PerizinanCuti::find($request->_id);
            $result = self::approvalCuti($cuti, $data);
        }

        if(!$result){
            return redirect()->back()->with('session', [
                'status' => 'danger', 
                'message' => 'Gagal memberikan keputusan cuti pegawai!'
            ]);
        }

        return redirect()->back()->with('session', [
            'status' => 'success', 
            'message' => 'Berhasil memberikan keputusan cuti pegawai!'
        ]);
    }

    private static function approvalCuti(PerizinanCuti $cuti, $persetujuan){
        $cuti->status_keputusan_pejabat_berwenang = $persetujuan['status_keputusan_pejabat_berwenang'];
        $cuti->alasan_keputusan_pejabat_berwenang = $persetujuan['alasan_keputusan_pejabat_berwenang'];
        $cuti->save();

        if($cuti){
            $catatanCuti = CatatanCuti::where('user_id',$cuti->user_id)
                ->where('tahun', now()->year)->first();

            $catatanCuti->sisa_cuti_tahunan = $catatanCuti->sisa_cuti_tahunan  - $cuti->jumlah_hari;
            $catatanCuti->cuti_tahunan_terpakai = $catatanCuti->cuti_tahunan_terpakai  + $cuti->jumlah_hari;
            $catatanCuti->save();
            return true;
        }

    }
}
