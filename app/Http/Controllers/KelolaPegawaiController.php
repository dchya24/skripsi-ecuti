<?php

namespace App\Http\Controllers;

use App\Enums\RumpunJabatan;
use App\Models\Bagian;
use App\Models\RumpunJabatan as RumpunJabatanModel;
use App\Models\CatatanCuti;
use App\Models\jabatan;
use App\Models\SubBagian;
use App\Models\User;
use App\Service\GlobalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KelolaPegawaiController extends Controller
{
    public function index(Request $request)
    {
        $data = User::with('jabatan.subbagian');
        $jabatan = Jabatan::all();
        $subbagian = SubBagian::all();

        if($request->query('nama_pegawai')){
            $data->where('nama', 'like', '%' . $request->query('nama_pegawai') . '%');
        }

        if($request->query('jabatan_id')){
            $data->where('jabatan_id', $request->query('jabatan_id'));
        }

        if($request->query('subbagian_id')){
            $data->whereRelation('jabatan', 'subbagian_id', $request->query('subbagian_id'));
        }

        $user = $data->paginate(10);
        $user->appends($request->input());

        return $this->view('kelola-pegawai.index', [
            'data' => $user,
            'jabatan' => $jabatan,
            'subbagian' => $subbagian
        ],sidebar_menu: 'kelola', sidebar_submenu: 'pegawai');
    }

    public function create()
    {
        $jabatan = jabatan::all();
        return $this->view('kelola-pegawai.add', [
            'jabatan' => $jabatan,
        ],sidebar_menu: 'kelola', sidebar_submenu: 'pegawai');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['password'] = Hash::make($request->password);
        $data['tmt_masuk'] = date_create($data['tmt_masuk']);
        $data['tgl_lahir'] = date_create($data['tgl_lahir']);

        $jabatan_id = $request->jabatan_id;

        $cantFill = [
            RumpunJabatan::ESELON_II,
            RumpunJabatan::ESELON_III,
            RumpunJabatan::ESELON_IV,
            RumpunJabatan::JFT_SUBKOORDINATOR
        ];

        $rumpunJabatan = RumpunJabatanModel::whereIn('value', $cantFill)->pluck('id');

        $jabatan = Jabatan::whereIn('rumpun_jabatan_id', $rumpunJabatan)->pluck('id');

        $listUser = User::whereIn('jabatan_id', $jabatan)->pluck('jabatan_id')->toArray();

        if(in_array($jabatan_id, $listUser)){
            return redirect()->back()->with("session", [
                'status' => 'danger',
                'message' => "Jabatan yang pilih sudah dijabat oleh pegawai lain!"
            ]);;
        }
        
        $user = User::create($data);
        if($user){
            $catatanCuti = CatatanCuti::insert([
                "jumlah_cuti_tahunan" => 12,
                "sisa_cuti_tahunan" => 12,
                "cuti_tahunan_terpakai" => 0,
                "jumlah_cuti_besar" => 0,
                "jumlah_cuti_sakit" => 0,
                "jumlah_alasan_penting" => 0,
                'tahun' => now()->year,
                'user_id' => $user->id
            ]);
        }

        return redirect()->back()->with("session", [
            'status' => 'success',
            'message' => "Berhasil menambahkan data pegawai baru!"
        ]);;
    }

    public function show($id)
    {
        $data = User::with('jabatan')->where('id', $id)->first();
        $jabatan = jabatan::all();
        $catatanCuti = GlobalService::getCutiHistories($data->id);

        return $this->view('kelola-pegawai.detail', [
            'data' => $data,
            'jabatan' => $jabatan,
            'catatanCuti' => $catatanCuti,
        ],sidebar_menu: 'kelola', sidebar_submenu: 'pegawai');
    }


    public function updateJabatan(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);

        $jabatan_id = $request->jabatan_id;

        $cantFill = [
            RumpunJabatan::ESELON_II,
            RumpunJabatan::ESELON_III,
            RumpunJabatan::ESELON_IV,
            RumpunJabatan::JFT_SUBKOORDINATOR
        ];

        $rumpunJabatan = RumpunJabatanModel::whereIn('value', $cantFill)->pluck('id');

        $jabatan = Jabatan::whereIn('rumpun_jabatan_id', $rumpunJabatan)->pluck('id');

        $listUser = User::whereIn('jabatan_id', $jabatan)->pluck('jabatan_id')->toArray();

        if(in_array($jabatan_id, $listUser)){
            return redirect()->back()->with("session", [
                'status' => 'danger',
                'message' => "Jabatan yang pilih sudah dijabat oleh pegawai lain!"
            ]);;
        }

        $updateData = User::where('id', $id)
        ->update($data);

        return redirect()->back()->with("session", [
            'status' => 'success',
            'message' => "Jabatan pegawai berhasil diubah!"
        ]);;
    }

    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);

        $data['tmt_masuk'] = date_create($data['tmt_masuk']);
        $data['tgl_lahir'] = date_create($data['tgl_lahir']);

        $updateData = User::where('id', $id)
        ->update($data);

        return redirect()->back()->with("session", [
            'status' => 'success',
            'message' => "Data pegawai berhasil diubah!"
        ]);;
    }

    public function destroy(Request $request, $id)
    {
        $user = User::destroy($id);

        return redirect()->route('pegawai.index')->with("session", [
            'status' => 'success',
            'message' => "Data Pegawai berhasil dihapus!"
        ]);;
    }

    public function updatePassword(Request $request, $id){
        $password = $request->password;
        $confirm_password = $request->confirm_password;

        if($password !== $confirm_password){
            return redirect()->back()->with("session", [
                'status' => 'danger',
                'message' => "Password Tidak Sama!"
            ]);
        }

        $hashPassword = bcrypt($password);

        $user = User::find($id);
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
