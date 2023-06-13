<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\CatatanCuti;
use App\Models\jabatan;
use App\Models\SubBagian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KelolaPegawaiController extends Controller
{
    public function index()
    {
        $data = User::with('jabatan.subbagian')->paginate(5);
        $data->appends(request()->input());

        return $this->view('kelola-pegawai.index', [
            'data' => $data
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
        
        $user = User::create($data);
        if($user){
            $catatanCuti = CatatanCuti::insert([
                "jumlah_cuti_tahunan" => 12,
                "sisa_cuti_tahunan" => 12,
                "cuti_tahunan_terpakai" => 0,
                "jumlah_cuti_besar" => 0,
                "jumlah_cuti_sakit" => 0,
                "jumlah_alasan_penting" => 0,
                'tahun' => now()->year
            ]);
        }

        return redirect()->back();
    }

    public function show($id)
    {
        $data = User::with('jabatan')->where('id', $id)->first();
        $jabatan = jabatan::all();

        return $this->view('kelola-pegawai.detail', [
            'data' => $data,
            'jabatan' => $jabatan,
        ],sidebar_menu: 'kelola', sidebar_submenu: 'pegawai');
    }


    public function updateJabatan(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);

        $updateData = User::where('id', $id)
        ->update($data);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);

        $updateData = User::where('id', $id)
        ->update($data);

        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $user = User::destroy($id);

        return redirect()->route('pegawai.index');
    }
}
