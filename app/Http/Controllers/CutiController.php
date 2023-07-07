<?php

namespace App\Http\Controllers;

use App\Enums\JenisCuti;
use App\Enums\JenisKelamin;
use App\Enums\StatusCuti;
use App\Http\Requests\AddCutiRequest;
use App\Models\jabatan;
use App\Models\PerizinanCuti;
use App\Models\User;
use App\Service\GlobalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CutiController extends Controller
{
    public function index(){
        $perizinanCuti = PerizinanCuti::where('user_id', Auth()->user()->id)
            ->orderBy('created_at', 'desc')->get();

        return $this->view('cuti.index', [
            'riwayat_cuti' => $perizinanCuti,
            'optionsJenisCuti' => JenisCuti::OPTIONS,
            'statusCutiOptions' => StatusCuti::OPTIONS
        ], sidebar_menu: "cuti", sidebar_submenu: "cuti.index");
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
        $jenis_cuti = $request->jenis_cuti_id;
        $data = $request->except(['_token']);

        $data['alamat_menjalankan_cuti'] = $data['alamat'];

        // $cekUserAccesAddCuti = self::userHasCreateCuti($user->id);
        // if(!$cekUserAccesAddCuti){
        //     return redirect()->back()->with("session", [
        //         'status' => 'danger',
        //         'message' => "Anda Tidak boleh mengajukan cuti lagi!"
        //     ]);
        // }

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

        if($dayDiff > 1 || $jenis_cuti != JenisCuti::CUTI_ALASAN_PENTING){
            $batasBidang = self::getBatasBidang($user->jabatan_id);
            dd($batasBidang);
        }

        return true;
        
        $atasan = GlobalService::getAtasanPejabat($user->jabatan_id);
        $data['atasan_langsung_id'] = $atasan['atasan_langsung']->id;

        $diffTmtMasuk = date_diff(now(), date_create($user->tmt_masuk));
        $diffYearTmtMasuk = $diffTmtMasuk->y;
        if($jenis_cuti == JenisCuti::CUTI_TAHUNAN){
            if($diffYearTmtMasuk < 1){
                return redirect()->back()->with("session", [
                    'status' => 'danger',
                    'message' => "Anda Belum bisa mengajukan cuti tahunan!"
                ]);
            }

            $sisa = GlobalService::getCountSisaCutiTahunan($user->id);
            if($data['jumlah_hari'] > $sisa){
                return redirect()->back()->with("session", [
                    'status' => 'danger',
                    'message' => "Lama hari cuti melebihi sisa cuti yang bisa dipakai!"
                ]);
            }

            $data['pejabat_berwenang_id'] = $atasan['pejabat_berwenang']->id;
            $data['jenis_cuti_id'] = JenisCuti::CUTI_TAHUNAN;
        }
        else if($jenis_cuti == JenisCuti::CUTI_ALASAN_PENTING){
            $cutiAlasanPenting = PerizinanCuti::where('jenis_cuti_id', JenisCuti::CUTI_ALASAN_PENTING)
                        ->whereYear('created_at', now()->year)
                        ->where('user_id', $user->id)->count();
            
            if($cutiAlasanPenting > 1){
                return redirect()->back()->with("session", [
                    'status' => 'danger',
                    'message' => "Anda sudah menggunakan cuti alasan penting!"
                ]);
            }
            $data['pejabat_berwenang_id'] = $atasan['pejabat_berwenang']->id;
            $data['jenis_cuti_id'] = JenisCuti::CUTI_ALASAN_PENTING;
        }
        else if($jenis_cuti == JenisCuti::CUTI_SAKIT){
            if($data['jumlah_hari'] <= 14){
                $data['pejabat_berwenang_id'] = $atasan['pejabat_berwenang']->id;
            }
            else{
                $kepalaDinas = jabatan::with('user')->where('nama', 'Kepala Dinas')->first();
                $data['pejabat_berwenang_id'] = $kepalaDinas->user[0]->id;
            }

            $data['jenis_cuti_id'] = JenisCuti::CUTI_SAKIT;
        }
        else if($jenis_cuti == JenisCuti::CUTI_BESAR){
            if($diffYearTmtMasuk < 5){
                return redirect()->back()->with("session", [
                    'status' => 'danger',
                    'message' => "Anda Belum bisa mengajukan cuti besar!"
                ]);
            }

            $CutiBesar = PerizinanCuti::where('jenis_cuti_id', JenisCuti::CUTI_BESAR)
                        ->whereYear('created_at', now()->year)
                        ->where('user_id', $user->id)->count();
            
            if($CutiBesar > 1){
                return redirect()->back()->with("session", [
                    'status' => 'danger',
                    'message' => "Anda sudah menggunakan cuti alasan penting!"
                ]);
            }
            $kepalaDinas = jabatan::with('user')->where('nama', 'Kepala Dinas')->first();
            $data['pejabat_berwenang_id'] = $kepalaDinas->user[0]->id;
        }
        else if($jenis_cuti == JenisCuti::CUTI_BERSALIN){
            if(Auth()->user()->jenis_kelamin == JenisKelamin::LAKI_LAKI){
                return redirect()->back()->with("session", [
                    'status' => 'danger',
                    'message' => "Cuti Bersalin hanya untuk perempuan!"
                ]);
            }

            $cutiBersalin = PerizinanCuti::where('jenis_cuti_id', JenisCuti::CUTI_BERSALIN)
                        ->count();
            if($cutiBersalin > 3){
                // Move to Cuti Besar
                $data['jenis_cuti_id'] = JenisCuti::CUTI_BESAR;
            }
            else{
                $data['jenis_cuti_id'] = JenisCuti::CUTI_BERSALIN;
            }
            $kepalaDinas = jabatan::with('user')->where('nama', 'Kepala Dinas')->first();
            $data['pejabat_berwenang_id'] = $kepalaDinas->user[0]->id;
            
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

    private static function getBatasBidang($jabatan_id){
        $jabatan = jabatan::find($jabatan_id);

        $listJabatan = Jabatan::where('subbagian_id', $jabatan->subbagian_id)->pluck('id');
        $listPegawai = User::whereIn('jabatan_id', $listJabatan)->get();

        $maxPermitt = (int) ceil($listPegawai->count() * 0.05);

        $data = DB::table('perizinan_cuti as pc')
        ->select('*')
        ->whereIn('user_id', function($query) use ($jabatan) {
            $query->select('u.id as user_id')
                ->from('jabatan as j')
                ->rightJoin('users as u', 'u.jabatan_id', 'j.id')
                ->where('j.subbagian_id', $jabatan->subbagian_id)
                ->get();
        })
        ->whereRaw('DATE(pc.created_at) = curdate()')
        ->get();

        // dd($maxPermitt, count(collect($data)->groupBy('user_id')));

        if($maxPermitt <= $data->count()){
            return false;
        }

        return true;
    }

    private static function userHasCreateCuti($user_id){
        $perizinanCuti = PerizinanCuti::where('user_id', $user_id)
                ->whereDate('created_at', now())
                ->count();

        return $perizinanCuti == 0 ? true : false;
    }
}
