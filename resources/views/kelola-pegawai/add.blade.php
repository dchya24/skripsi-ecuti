@extends('template.app')
@section('title', 'Approval')
@section('content')
  @if(session('session'))
  <div class="alert alert-{{session('session')['status']}} alert-dismissible fade show" role="alert">
    {{session('session')['message']}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(session('session'))
  <div class="alert alert-{{session('session')['status']}} alert-dismissible fade show" role="alert">
    {{session('session')['message']}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  <h5>
    <a href="{{route('pegawai.index')}}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left"></i>
      Back
    </a>
    Tambah Data Pegawai
  </h5>

  <form method="POST" class="form border-top mt-3" action="{{route('pegawai.create')}}">
    <div class="form-group row mt-5">
      <label for="nama" class="col-md-2 col-form-label">Nama</label>
      <div class="col-md-8">
        <input type="text" class="form-control" id="nama" name="nama">
      </div>
    </div>

    <div class="form-group row">
      <label for="nik" class="col-md-2 col-form-label">NIK</label>
      <div class="col-md-8">
        <input type="text" class="form-control" id="nik" name="nik">
      </div>
    </div>

    <div class="form-group row">
      <label for="nip" class="col-md-2 col-form-label">NIP</label>
      <div class="col-md-8">
        <input type="text" class="form-control" id="nip" name="nip">
      </div>
    </div>

    <div class="form-group row">
      <label for="email" class="col-md-2 col-form-label">Email</label>
      <div class="col-md-8">
        <input type="text" class="form-control" id="email" name="email">
      </div>
    </div>

    <div class="form-group row">
      <label for="no_telp" class="col-md-2 col-form-label">No Telpon</label>
      <div class="col-md-8">
        <input type="text" class="form-control" id="no_telp" name="no_telp">
      </div>
    </div>

    <div class="form-group row">
      <label for="gelar" class="col-md-2 col-form-label">Gelar</label>
      <div class="col-md-8">
        <input type="text" class="form-control w-25 d-inline" id="gelar1" name="gelar_depan" placeholder="Gelar Depan">
        <input type="text" class="form-control w-25 d-inline" id="gelar2" name="gelar_belakang" placeholder="Gelar Belakang">
      </div>
    </div>

    <div class="form-group row">
      <label for="tgl_lahir" class="col-md-2 col-form-label">Tanggal Lahir</label>
      <div class="col-md-8">
        <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir">
      </div>
    </div>

    <div class="form-group row">
      <label for="tempat_lahir" class="col-md-2 col-form-label">Jenis Kelamin</label>
      <div class="col-md-8">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="1">
          <label class="form-check-label" for="laki"> Laki Laki </label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="2">
          <label class="form-check-label" for="perempuan"> Perempuan </label>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label for="tempat_lahir" class="col-md-2 col-form-label">Tempat Lahir</label>
      <div class="col-md-8">
        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
      </div>
    </div>

    <div class="form-group row">
      <label for="alamat" class="col-md-2 col-form-label">Alamat</label>
      <div class="col-md-8">
        <textarea name="alamat" class="form-control" id="alamat" rows="3"></textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="tmt_masuk" class="col-md-2 col-form-label">TMT Masuk</label>
      <div class="col-md-8">
        <input type="text" class="form-control" id="tmt_masuk" name="tmt_masuk">
      </div>
    </div>

    <div class="form-group row">
      <label for="password" class="col-md-2 col-form-label">Password</label>
      <div class="col-md-8">
        <input type="text" class="form-control" id="password" name="password">
      </div>
    </div>

    <div class="form-group row mt-5">
      <label for="jabatan_id" class="col-md-2 col-form-label">Jabatan</label>
      <div class="col-md-8">
        <select name="jabatan_id" id="jabatan_id" class="form-control">
          @foreach ($jabatan as $item)
              <option value="{{$item->id}}">{{ $item->nama . ' - ' . $item->subbagian->nama}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-md-10 text-right">
        @csrf
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-paper-plane"></i>
          Tambah Data Pegawai
        </button>
      </div>
    </div>
  </form>
  

@endsection