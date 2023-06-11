@extends('template.app')
@section('title', 'welcome!')
@section('content')
  <div class="row">
    <div class="col-md-4">
        <h6 class="mt-2">Data Diri</h6>
        @include('component.table_pegawai')
    </div>
    <div class="col-md-8">
      <h6 class="mt-2">Table Cuti Tahunan Pegawai</h6>
      <table class="table">
        <thead>
          <tr>
            <td>Tahun</td>
            <td>Terpakai</td>
            <td>Sisa</td>
            <td>Jumlah</td>
          </tr>
        </thead>
        <tbody>
          @foreach($catatanCuti as $catatan)
              <tr>
                <td>{{$catatan->tahun}}</td>
                <td>{{$catatan->cuti_tahunan_terpakai}}</td>
                <td>{{$catatan->sisa_cuti_tahunan}}</td>
                <td>{{$catatan->jumlah_cuti_tahunan}}</td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="col-md-12">
      <h6 class="pt-2 border-top">Atasan Langsung</h6>
      <table class="table table-borderless">
        <tr class="d-flex">
          <td class="col-3">Nama</td>
          <td class="col-4">{{$atasanLangsung->full_name}}</td>
        </tr>
        <tr class="d-flex">
          <td class="col-3">Jabatan</td>
          <td class="col-4">{{$atasanLangsung->jabatan->nama}}</td>
        </tr>
      </table>
    </div>

    <div class="col-md-12">
      <h6 class="pt-2 border-top">Pejabat Berwenang</h6>
      <table class="table table-borderless">
        <tr class="d-flex">
          <td class="col-3">Nama</td>
          <td class="col-4">{{getFullName($pejabatBerwenang->gelar_depan, $pejabatBerwenang->nama, $pejabatBerwenang->gelar_belakang)}}</td>
        </tr>
        <tr class="d-flex">
          <td class="col-3">Jabatan</td>
          <td class="col-4">{{$pejabatBerwenang->jabatan}}</td>
        </tr>
      </table>
    </div>
  </div>
@endsection