<?php

namespace App\Http\Controllers;

use App\Models\jabatan;
use App\Models\RumpunJabatan;
use App\Models\SubBagian;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaJabatanController extends Controller
{
    
    public function index(Request $request)
    {
        $data = jabatan::with('subbagian.bagian');

        if($request->query('nama_jabatan')){
            $data->where('nama', 'like', '%' . $request->query('nama_jabatan') . '%');
        }

        $jabatan = $data->paginate(5);
        $jabatan->appends(request()->input());

        return $this->view('kelola-jabatan.index', [
            'data' => $jabatan
        ],sidebar_menu: 'kelola', sidebar_submenu: 'jabatan');
    }

    
    public function create()
    {
        $subbagian = SubBagian::with('bagian')->get();
        $rumpunJabatan = RumpunJabatan::all();

        return $this->view('kelola-jabatan.add', [
            'subbagian' => $subbagian,
            'rumpunJabatan' => $rumpunJabatan
        ],sidebar_menu: 'kelola', sidebar_submenu: 'jabatan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $user = jabatan::create($data);

        return redirect()->route('jabatan.index')->with("session", [
            'status' => 'success',
            'message' => "Berhasil menambahkan data jabatan baru!"
        ]);;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subbagian = SubBagian::with('bagian')->get();
        $rumpunJabatan = RumpunJabatan::all();
        $jabatan = jabatan::find($id);

        return $this->view('kelola-jabatan.detail', [
            'jabatan' => $jabatan,
            'subbagian' => $subbagian,
            'rumpunJabatan' => $rumpunJabatan
        ],sidebar_menu: 'kelola', sidebar_submenu: 'jabatan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);

        jabatan::where('id', $id)->update($data);

        return redirect()->back()->with("session", [
            'status' => 'success',
            'message' => "Data jabatan berhasil diubah!"
        ]);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('jabatan_id', $id)->update([
            'jabatan_id' => null
        ]);
        jabatan::destroy($id);

        return redirect()->route('jabatan.index')->with("session", [
            'status' => 'success',
            'message' => "Data jabatan berhasil dihapus!"
        ]);;

    }
}
