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

  <h5>Data Pegawai</h5>

  <div class="row">
    <div class="col-md-9">
      <form method="GET" class="form-inline row">
        <div class="col-md-3">
          <input type="text" class="form-control" name="nama_pegawai" placeholder="Cari nama pegawai">
        </div>
        <div class="col-md-3">
          <select class="form-control w-100" name="jabatan_id" id="">
            <option value="">Jabatan</option>
            @foreach ($jabatan as $item)
              <option value="{{$item->id}}">{{$item->nama}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <select class="form-control w-100" name="subbagian_id" id="">
              <option value="">Subbagian/Seksi</option>
              @foreach ($subbagian as $item)
                <option value="{{$item->id}}">{{$item->nama}}</option>
              @endforeach
          </select>
        </div>
        
        <div class="col-md-3">
          <button type="submit" class="btn btn-primary">Filter</button>
          <button type="clear" class="btn btn-outline-secondary mx-1">Reset</button>          
        </div>
      </form>
    </div>
    <div class="col-md-4 mt-3">
      <a href="{{route('pegawai.create-page')}}" class="btn btn-success">
        <i class="fas fa-edit"></i>
        Tambah Data Pegawai
      </a>
    </div>
  </div>

  <table class="table table-striped table-bordered mt-2">
    <thead>
      <tr>
        <th>No</th>
        <th>NIP</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Jabatan</th>
        <th>Unit Kerja</th>
        <th>Masa Kerja</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($data as $item)
        <tr>
          <td>{{ ($data->currentpage()-1) * $data->perpage() + $loop->index + 1 }}</td>
          <td>{{ $item->nip }}</td>
          <td>{{ $item->nik }}</td>
          <td>{{ getFullName($item->gelar_depan,$item->nama, $item->gelar_belakang) }}</td>
          <td>{{ $item->email }}</td>
          <td>{{ $item->jabatan->nama }}</td>
          <td>{{ $item->jabatan->subbagian->nama }}</td>
          <td>{{ masaKerja($item->tmt_masuk) }}</td>
          <td>
            <a href="{{ route('pegawai.show', $item->id) }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail dan Edit">
              <i class="fas fa-edit"></i>
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="9">
            <h6 class="text-center">No Data!</h6>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
  {{$data->onEachSide(10)->links()}}
@endsection