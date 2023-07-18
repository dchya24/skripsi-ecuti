<?php

namespace App\Http\Controllers;

use App\Enums\JenisCuti;
use App\Enums\JenisKelamin;
use App\Enums\RumpunJabatan;
use App\Enums\StatusCuti;
use App\Http\Requests\AddCutiRequest;
use App\Models\CatatanCuti;
use App\Models\Jabatan;
use App\Models\PerizinanCuti;
use App\Models\User;
use App\Service\GlobalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

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
        DB::beginTransaction();
        $user = Auth()->user();
        $request->validated();
        $jenis_cuti = $request->jenis_cuti_id;
        $data = $request->except(['_token']);

        $data['alamat_menjalankan_cuti'] = $data['alamat'];

        $cekUserAccesAddCuti = self::userHasCreateCuti($user->id);
        if(!$cekUserAccesAddCuti){
            return redirect()->back()->with("session", [
                'status' => 'danger',
                'message' => "Anda Tidak boleh mengajukan cuti lagi!"
            ]);
        }

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
            if($batasBidang){
                return redirect()->back()->with("session", [
                    'status' => 'danger',
                    'message' => "Pengajuan cuti per bagian/divisi sudah melebihi limit!"
                ]);
            }
        }
        
        $atasan = GlobalService::getAtasanPejabat($user->jabatan_id);

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
                        ->whereMonth('created_at', now()->month)
                        ->where('user_id', $user->id)->count();
            
            if($cutiAlasanPenting >= 1){
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
                $kepalaDinas = Jabatan::with('user')->where('nama', 'Kepala Dinas')->first();
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
            $kepalaDinas = Jabatan::with('user')->where('nama', 'Kepala Dinas')->first();
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
            $kepalaDinas = Jabatan::with('user')->where('nama', 'Kepala Dinas')->first();
            $data['pejabat_berwenang_id'] = $kepalaDinas->user[0]->id;
        }
        else if($jenis_cuti == JenisCuti::CUTI_DILUAR_TANGGUNGAN_NEGARA){
            if($diffYearTmtMasuk < 5){
                return redirect()->back()->with("session", [
                    'status' => 'danger',
                    'message' => "Anda Belum bisa mengajukan Cuti Diluar Tanggungan Negara!"
                ]);
            }

            $diluarTanggungan = PerizinanCuti::where('jenis_cuti_id', JenisCuti::CUTI_DILUAR_TANGGUNGAN_NEGARA)
                        ->whereYear('created_at', now()->year)
                        ->where('user_id', $user->id)->count();
            
            if($diluarTanggungan > 1){
                return redirect()->back()->with("session", [
                    'status' => 'danger',
                    'message' => "Anda sudah menggunakan Cuti Diluar Tanggungan Negara!"
                ]);
            }
            $kepalaDinas = Jabatan::with('user')->where('nama', 'Kepala Dinas')->first();
            $data['pejabat_berwenang_id'] = $kepalaDinas->user[0]->id;
        }

        $isEselonIIIorII = self::isEselonIIIorII($user);

        if($isEselonIIIorII){
            $data['status_persetujuan_atasan_langsung'] = StatusCuti::DISETUJUI;
        }
        else{
            $data['status_persetujuan_atasan_langsung'] = StatusCuti::PROSES;
            $data['atasan_langsung_id'] = $atasan['atasan_langsung']->id;
        }

        $data['user_id'] = $user->id;

        if(!empty($request->file)){
            $bukti = $request->file('bukti');
            $filename = time() . '-' . $user->id .'.'. $bukti->extension();
            dd($bukti); 
            $path = $request->file('bukti')->move('bukti', $filename, 'public');
            $data['bukti'] = $path;
        }

        $perizinanCuti = PerizinanCuti::create($data);
        $dataCuti = PerizinanCuti::find($perizinanCuti->id);
        // dd(PerizinanCuti::find($perizinanCuti->id));

        $historiCuti = CatatanCuti::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')->limit(3)->get();

        $pdf = Pdf::loadView('cuti.print', [
            'userData' => $user,
            'perizinanCuti' => $dataCuti,
            'historiCuti' => $historiCuti,
            'statusCuti' => StatusCuti::PRINT_PREVIEW,
            'jenisCuti' => JenisCuti::array,
        ])->setPaper('a4');

        $fileName = 'form-cuti-'. $perizinanCuti->id . '.pdf';
        $pdf->save(public_path('form/' . $fileName));
        DB::commit();

        return redirect()->back()->with("session", [
            'status' => 'success',
            'message' => "Berhasil Mengajukan Permohonan cuti!"
        ]);
    }

    public function show($id){
        $data = PerizinanCuti::with(['user', 'user.jabatan', 'atasanLangsung', 'pejabatBerwenang'])
            ->where('id', $id)
            ->first();

        if(!$data){
            return abort(404);
        }
        if($data->user_id != Auth::user()->id){
            return abort(401);
        }

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

    public function update(Request $request, $id){
        $perizinanCuti = PerizinanCuti::find($id);

        if($perizinanCuti->user_id != Auth::user()->id){
            return abort(402);
        }
        
        if($perizinanCuti->status_persetujuan_atasan_langsung != StatusCuti::PERUBAHAN || $perizinanCuti->status_keputusan_pejabat_berwenang != StatusCuti::PERUBAHAN){
            return redirect()->back()->with("session", [
                'status' => 'danger',
                'message' => "Anda Tidak boleh mengajukan cuti lagi!"
            ]);
        }
    }

    private static function getBatasBidang($jabatan_id){
        $jabatan = Jabatan::find($jabatan_id);

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
        // ->toSql();

        // dd($data);
        // dd($maxPermitt, count(collect($data)->groupBy('user_id')));

        // cek pengajuan cuti hari ini mencapai limit atau tidak
        if($data->count() >= $maxPermitt){
            return true;
        }

        return false;
    }

    private static function userHasCreateCuti($user_id){
        $perizinanCuti = PerizinanCuti::where('user_id', $user_id)
                ->whereDate('created_at', now())
                ->count();

        return $perizinanCuti == 0 ? true : false;
    }

    public function print($id){

        $fileName = 'form-cuti-'. $id . '.pdf';
        $path = public_path('form/' . $fileName);

        if(file_exists($path)){
            return response()->file($path);
        }

        $perizinanCuti = PerizinanCuti::find($id);
        $userData = User::with(['jabatan', 'jabatan.subbagian'])->where('id', $perizinanCuti->user_id)->first();
        $historiCuti = CatatanCuti::where('user_id', $userData->id)
            ->orderBy('created_at', 'desc')->limit(3)->get();

        // dd($historiCuti);
        // return view('cuti.print');
        $pdf = Pdf::loadView('cuti.print', [
            'userData' => $userData,
            'perizinanCuti' => $perizinanCuti,
            'historiCuti' => $historiCuti,
            'statusCuti' => StatusCuti::PRINT_PREVIEW,
            'jenisCuti' => JenisCuti::array,
        ])->setPaper('a4');
        $pdf->save(public_path('form/' . $fileName));
        return $pdf->stream();
    }

    private static function isEselonIIIorII(User $user){
        $jabatan = $user->jabatan;
        $rumpun_jabatan = $jabatan->rumpunJabatan;

        return in_array($rumpun_jabatan->value, [
            RumpunJabatan::ESELON_II,
            RumpunJabatan::ESELON_III
        ]);
    }
}
