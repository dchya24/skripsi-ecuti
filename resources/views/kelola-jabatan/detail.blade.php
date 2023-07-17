@extends('template.app')
@section('title', 'Jabatan')
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
    <a href="{{route('jabatan.index')}}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left"></i>
      Back
    </a>
    Detail Data Jabatan
  </h5>

  <form method="POST" class="form border-top mt-3" action="{{route('jabatan.update', $jabatan->id)}}">
    <div class="form-group row mt-5">
      <label for="nama" class="col-md-2 col-form-label">Nama Jabatan</label>
      <div class="col-md-5">
        <input type="text" class="form-control" id="nama" name="nama" value="{{$jabatan->nama}}">
      </div>
    </div>

    <div class="form-group row mt-5">
      <label for="subbagian_id" class="col-md-2 col-form-label">Subbagian</label>
      <div class="col-md-5">
        <select name="subbagian_id" id="subbagian_id" class="form-control">
          @foreach ($subbagian as $item)
              <option value="{{$item->id}}" @if($jabatan->subbagian_id == $item->id) {{'selected'}} @endif>{{ $item->nama . ' - ' . $item->bagian->nama}}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group row mt-5">
      <label for="rumpun_jabatan_id" class="col-md-2 col-form-label">Rumpun Jabatan</label>
      <div class="col-md-5">
        <select name="rumpun_jabatan_id" id="rumpun_jabatan_id" class="form-control">
          @foreach ($rumpunJabatan as $item)
              <option value="{{$item->id}}" @if($jabatan->rumpun_jabatan_id == $item->id) {{'selected'}} @endif>{{ $item->nama}}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-7 text-right">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-paper-plane"></i>
          Update Data Jabatan
        </button>
      </div>
    </div>
  </form>
  

@endsection