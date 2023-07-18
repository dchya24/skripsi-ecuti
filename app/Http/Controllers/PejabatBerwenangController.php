<?php

namespace App\Http\Controllers;

use App\Enums\JenisCuti;
use App\Enums\StatusCuti;
use App\Models\CatatanCuti;
use App\Models\PerizinanCuti;
use App\Models\User;
use App\Service\GlobalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PejabatBerwenangController extends Controller
{
    public function index(Request $request){
        $data = PerizinanCuti::with(['user', 'user.jabatan', 'atasanLangsung', 'pejabatBerwenang'])
            // ->where('pejabat_berwenang_id' , Auth::user()->id)
            ->where('status_persetujuan_atasan_langsung', StatusCuti::DISETUJUI)
            ->where('user_id', '!=', null);
            ;
            // ->where('status_keputusan_pejabat_berwenang', StatusCuti::PROSES);

        $filterStatus = $request->query('status_pejabat');
        $filterJenisCuti = $request->query('jenis_cuti');

        if(!empty($filterStatus) && $filterStatus !== 'all'){
            
            $data = $data->where('status_keputusan_pejabat_berwenang', $filterStatus);
        }

        if(!empty($filterJenisCuti) && $filterJenisCuti !== 'all'){
            $data = $data->where('jenis_cuti_id', $filterJenisCuti);
        }

        $riwayat = $data->orderBy('created_at', 'desc')->paginate(10);
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
        ], sidebar_menu: 'approval', sidebar_submenu: 'approval.pejabat');
    }

    public function keputusanCuti(Request $request){
        DB::beginTransaction();
        $data = [
            "status_keputusan_pejabat_berwenang" => $request->status,
            "alasan_keputusan_pejabat_berwenang" => $request->alasan_keputusan
        ];

        $result = true;
        $cuti = PerizinanCuti::find($request->_id);
        $result = self::approvalCuti($cuti, $data);

        if(!$result){
            DB::rollBack();
            return redirect()->back()->with('session', [
                'status' => 'danger', 
                'message' => 'Gagal memberikan keputusan cuti pegawai!'
            ]);
        }

        DB::commit();
        return redirect()->back()->with('session', [
            'status' => 'success', 
            'message' => 'Berhasil memberikan keputusan cuti pegawai!'
        ]);
    }

    private static function approvalCuti(PerizinanCuti $cuti, $persetujuan){
        $cuti->status_keputusan_pejabat_berwenang = $persetujuan['status_keputusan_pejabat_berwenang'];
        $cuti->alasan_keputusan_pejabat_berwenang = $persetujuan['alasan_keputusan_pejabat_berwenang'];
        $cuti->save();

        $fileName = 'form-cuti-'. $cuti->id . '.pdf';
        $path = public_path('form/' . $fileName);
        if(file_exists($path)){
            unlink($path);
        }

        $userData = User::with(['jabatan', 'jabatan.subbagian'])->where('id', $cuti->user_id)->first();
        $historiCuti = CatatanCuti::where('user_id', $userData->id)
            ->orderBy('created_at', 'desc')->limit(3)->get();

        // dd($historiCuti);
        // return view('cuti.print');
        $pdf = Pdf::loadView('cuti.print', [
            'userData' => $userData,
            'perizinanCuti' => $cuti,
            'historiCuti' => $historiCuti,
            'statusCuti' => StatusCuti::PRINT_PREVIEW, 
            'jenisCuti' => JenisCuti::array, 
        ])->setPaper('a4');
        $pdf->save(public_path('form/' . $fileName));

        if($cuti->status_keputusan_pejabat_berwenang == StatusCuti::DISETUJUI){
            $catatanCuti = CatatanCuti::where('user_id',$cuti->user_id)
                ->where('tahun', now()->year)->first();

            if($cuti->jenis_cuti_id == JenisCuti::CUTI_TAHUNAN){
                // $catatanCuti->sisa_cuti_tahunan = $catatanCuti->sisa_cuti_tahunan  - $cuti->jumlah_hari;
                // $catatanCuti->cuti_tahunan_terpakai = $catatanCuti->cuti_tahunan_terpakai  + $cuti->jumlah_hari;
                $total = $cuti->jumlah_hari;
                $sisa = $total;
                $cct = GlobalService::getCutiHistories($cuti->user_id);
                foreach($cct as $key => $item){
                    if($item->sisa_cuti_tahunan < $sisa && $sisa > 0){
                        $temp = $item->sisa_cuti_tahunan - $item->sisa_cuti_tahunan;
                        $sisa = $sisa - $item->sisa_cuti_tahunan;
                        $item->cuti_tahunan_terpakai = $item->cuti_tahunan_terpakai + $temp;
                        $item->sisa_cuti_tahunan = $temp;
                        
                    }
                    else if($item->sisa_cuti_tahunan > $sisa && $sisa > 0){
                        $temp =  $item->sisa_cuti_tahunan - $sisa;
                        $item->sisa_cuti_tahunan = $temp;
                        $item->cuti_tahunan_terpakai = $item->cuti_tahunan_terpakai + $sisa;
                        $sisa = $sisa - $sisa;
                    }
                    $item->save();
                }
                // dd($cct);
            }
            else if($cuti->jenis_cuti_id == JenisCuti::CUTI_ALASAN_PENTING){
                $catatanCuti->jumlah_alasan_penting = $catatanCuti->jumlah_alasan_penting + $cuti->jumlah_hari;
            }
            else if($cuti->jenis_cuti_id == JenisCuti::CUTI_SAKIT){
                $catatanCuti->jumlah_cuti_sakit = $catatanCuti->jumlah_cuti_sakit + $cuti->jumlah_hari;
            }
            else if($cuti->jenis_cuti_id == JenisCuti::CUTI_BESAR){
                $catatanCuti->jumlah_cuti_besar = $catatanCuti->jumlah_cuti_besar + $cuti->jumlah_hari;
            }
            else if($cuti->jenis_cuti_id == JenisCuti::CUTI_BERSALIN){
                $catatanCuti->jumlah_cuti_melahirkan = $catatanCuti->jumlah_cuti_melahirkan + $cuti->jumlah_hari;
            }
            else if($cuti->jenis_cuti_id == JenisCuti::CUTI_DILUAR_TANGGUNGAN_NEGARA){
                $catatanCuti->jumlah_tanggungan_diluar_negara = $catatanCuti->jumlah_tanggungan_diluar_negara + $cuti->jumlah_hari;
            }

            
            $catatanCuti->save();
        }

        return true;
    }
}
