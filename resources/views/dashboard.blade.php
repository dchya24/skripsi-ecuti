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
            <td>Jumlah</td>
            <td>Terpakai</td>
            <td>Sisa</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>2023</td>
            <td>12</td>
            <td>3</td>
            <td>9</td>
          </tr>
          <tr>
            <td>2022</td>
            <td>12</td>
            <td>8</td>
            <td>4</td>
          </tr>
          <tr>
            <td>2021</td>
            <td>12</td>
            <td>10</td>
            <td>2</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col-md-12">
      <h6 class="pt-2 border-top">Atasan Langsung</h6>
      <table class="table table-borderless">
        <tr>
          <td>Nama</td>
          <td>Ria Lantasih</td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>Pengembangan Peran Serta Masyarakat</td>
        </tr>
      </table>
    </div>

    <div class="col-md-12">
      <h6 class="pt-2 border-top">Pejabat Berwenang</h6>
      <table class="table table-borderless">
        <tr>
          <td>Nama</td>
          <td>Ria Lantasih</td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>Pengembangan Peran Serta Masyarakat</td>
        </tr>
      </table>
    </div>
  </div>
@endsection