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
  @if(session('session'))
  <div class="alert alert-{{session('session')['status']}} alert-dismissible fade show" role="alert">
    {{session('session')['message']}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  <h5>Data Jabatan</h5>

  <div class="row">
    <div class="col-md-10">
      <form method="GET" class="form-inline">
        <input type="text" class="form-control" name="nama_jabatan" placeholder="Cari nama jabatan">
    
        <button type="submit" class="btn btn-primary mx-1">Filter</button>
        <button type="clear" class="btn btn-outline-secondary mx-1">Reset</button>
      </form>
    </div>
    <div class="col-md-4 mt-3">
      <a href="{{route('jabatan.create-page')}}" class="btn btn-success">
        <i class="fas fa-edit"></i>
        Tambah Data Jabatan
      </a>
    </div>
  </div>

  <table class="table table-striped table-bordered mt-2">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Jabatan</th>
        <th>Subbagian</th>
        <th>Bagian</th>
        <th>Rumpun Jabatan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($data as $item)
        <tr>
          <td>{{ ($data->currentpage()-1) * $data ->perpage() + $loop->index + 1 }}</td>
          <td>{{ $item->nama }}</td>
          <td>{{ $item->subbagian->nama }}</td>
          <td>{{ $item->subbagian->bagian->nama }}</td>
          <td>{{ $item->rumpunJabatan->nama }}</td>
          <td>
            <a href="{{ route('jabatan.show', $item->id) }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail dan Edit">
              <i class="fas fa-edit"></i>
            </a>
            <form action="{{route('jabatan.delete', $item->id)}}" method="POST" class="form d-inline">
              @csrf
              @method('DELETE')
              <input type="hidden" name="id" value={{$item->id}}>
              <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Data">
                <i class="fas fa-trash-alt"></i>
              </button>
            </form>
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
  {{$data->onEachSide(5)->links()}}
@endsection