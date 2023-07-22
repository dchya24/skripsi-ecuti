@extends('template.app')
@section('title', 'Profile')
@section('content')
  @if(session('session'))
  <div class="alert alert-{{session('session')['status']}} alert-dismissible fade show" role="alert">
    {{session('session')['message']}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  
  <h5>
    <a href="{{route('dashboard')}}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left"></i>
      Back
    </a>
    Profile
  </h5>

  <form method="POST" class="form border-top mt-3" action="{{route('pegawai.update', $data->id)}}">
    <div class="form-group row mt-5">
      <label for="nama" class="col-md-2 col-form-label">Nama</label>
      <div class="col-md-8">
        <input type="text" readonly class="form-control-plaintext" id="nama" name="nama" value="{{$data->nama}}">
      </div>
    </div>

    <div class="form-group row">
      <label for="nik" class="col-md-2 col-form-label">NIK</label>
      <div class="col-md-8">
        <input type="text" readonly class="form-control-plaintext" id="nik" name="nik" value="{{$data->nik}}">
      </div>
    </div>

    <div class="form-group row">
      <label for="nip" class="col-md-2 col-form-label">NIP</label>
      <div class="col-md-8">
        <input type="text" readonly class="form-control-plaintext" id="nip" name="nip" value="{{$data->nip}}">
      </div>
    </div>

    <div class="form-group row">
      <label for="email" class="col-md-2 col-form-label">Email</label>
      <div class="col-md-8">
        <input type="text" readonly class="form-control-plaintext" id="email" name="email" value="{{$data->email}}">
      </div>
    </div>

    <div class="form-group row">
      <label for="no_telp" class="col-md-2 col-form-label">No Telpon</label>
      <div class="col-md-8">
        <input type="text" readonly class="form-control-plaintext" id="no_telp" name="no_telp" value="{{$data->no_telp}}">
      </div>
    </div>

    <div class="form-group row">
      <label for="no_telp" class="col-md-2 col-form-label">Gelar</label>
      <div class="col-md-8">
        <input type="text" readonly class="form-control-plaintext w-25 d-inline" id="no_telp" name="gelar_depan" placeholder="Gelar Depan" value="{{$data->gelar_depan}}">
        <input type="text" readonly class="form-control-plaintext w-25 d-inline" id="no_telp" name="gelar_belakang" placeholder="Gelar Belakang" value="{{$data->gelar_belakang}}">
      </div>
    </div>

    <div class="form-group row">
      <label for="tgl_lahir" class="col-md-2 col-form-label">Tanggal Lahir</label>
      <div class="input-group date tgl_lahir col-md-8" id="">
        <input readonly class="form-control-plaintext datepicker" type="text" id="tgl_lahir" name="tgl_lahir" placeholder="mm/dd/yyyy" value="{{Carbon\Carbon::parse($data->tgl_lahir)->format('m/d/Y')}}">
        <div class="input-group-append">
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label for="tempat_lahir" class="col-md-2 col-form-label">Jenis Kelamin</label>
      <div class="col-md-8">
        <div class="form-check form-check-inline">
          <input readonly class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="1" @if($data->jenis_kelamin === 1) {{'checked'}} @endif>
          <label class="form-check-label" for="laki"> Laki Laki </label>
        </div>
        <div class="form-check form-check-inline">
          <input readonly class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="1" @if($data->jenis_kelamin === 2) {{'checked'}} @endif>
          <label class="form-check-label" for="perempuan"> Perempuan </label>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label for="tempat_lahir" class="col-md-2 col-form-label">Tempat Lahir</label>
      <div class="col-md-8">
        <input readonly type="text" class="form-control-plaintext" id="tempat_lahir" name="tempat_lahir" value="{{$data->tempat_lahir}}">
      </div>
    </div>

    <div class="form-group row">
      <label for="alamat" class="col-md-2 col-form-label">Alamat</label>
      <div class="col-md-8">
        <textarea readonly name="alamat" readonly class="form-control-plaintext" id="alamat" rows="3">{{$data->alamat}}</textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="tmt_masuk" class="col-md-2 col-form-label">TMT Masuk</label>
      <div class="input-group date tmt_masuk col-md-8" id="">
        <input readonly class="form-control-plaintext datepicker" type="text" id="tmt_masuk" name="tmt_masuk" placeholder="mm/dd/yyyy" value="{{Carbon\Carbon::parse($data->tmt_masuk)->format('m/d/Y')}}">
      </div>
    </div>
  </form>

  <div class="mt-2 py-2">
    <h6 class="py-3 border-bottom">Catatan Cuti</h6>
    <div class="row pt-3">
      <div class="col-md-2">
        Cuti Tahunan
      </div>
      <div class="col-md-2">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Tahun</th>
              <th>Sisa</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($catatanCuti as $item)
                <tr>
                  <td>{{$item->tahun}}</td>
                  <td>{{$item->sisa_cuti_tahunan}}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2">Cuti Sakit</div>
      <div class="col-md-3">{{$catatanCuti[0]->jumlah_cuti_sakit}}</div>
    </div>
    <div class="row">
      <div class="col-md-2">Cuti Besar</div>
      <div class="col-md-3">{{$catatanCuti[0]->jumlah_cuti_besar}}</div>
    </div>
    <div class="row">
      <div class="col-md-2">Cuti Alasan Penting</div>
      <div class="col-md-3">{{$catatanCuti[0]->jumlah_alasan_penting}}</div>
    </div>
  </div>
  
  <div class="mt-2 py-2">
    <h6 class="py-3 border-bottom">Ganti Password</h6>
    <form method="POST" class="form" action="{{route('profile.password')}}">
      <div class="form-group row">
        <label for="password" class="col-md-2 col-form-label">Password</label>
        <div class="col-md-8">
          <input type="password" class="form-control" id="password" name="password" value="" min=8 required>
        </div>
      </div>
      <div class="form-group row">
        <label for="confirm_password" class="col-md-2 col-form-label">Confirm Password</label>
        <div class="col-md-8">
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" min=8 required>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-5 col-form-label"></label>
  
        <div class="col-md-5 text-right">
          @csrf
          <button type="submit" class="btn btn-warning">
            <i class="fas fa-paper-plane"></i>
            Ganti Password
          </button>
        </div>
      </div>
    </form>
  </div>
  
  @endsection