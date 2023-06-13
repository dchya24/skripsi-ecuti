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

  <h5>Pertimbangan Atasan Langsung</h5>

  <form method="GET" class="form-inline">
    <select name="" id="" class="form-control mr-1">
      <option value="">Jenis Cuti</option>
      @foreach ($optionsJenisCuti as $key => $option)
          <option value="{{$key}}">{{$option}}</option>
      @endforeach
    </select>

    <select name="status_atasan" class="form-control mx-1">
      <option value="">Status Atasan</option>
      @foreach ($statusCutiOptions as $key => $option)
          <option value="{{$key}}">{{$option}}</option>
      @endforeach
    </select>

    <button type="submit" class="btn btn-primary mx-1">Filter</button>
    <button type="clear" class="btn btn-outline-secondary mx-1">Reset</button>
  </form>

  <table class="table table-striped table-bordered mt-4">
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal Pengajuan</th>
        <th>NIP</th>
        <th>Nama</th>
        {{-- <th>Jabatan</th> --}}
        <th>Unit Kerja</th>
        <th>Masa Kerja</th>
        <th>Jenis Cuti</th>
        <th>Jumlah Hari</th>
        <th>Mulai</th>
        <th>Akhir</th>
        <th>Status Cuti</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($data as $item)
        <tr>
          <td> {{$loop->iteration}} </td>
          <td>{{$item->created_at->format('H:i, d-m-Y')}} </td>
          <td>{{$item->user->nip}} </td>
          <td>{{$item->user->nama}} </td>
          {{-- <td>{{$item->user->jabatan->nama}} </td> --}}
          <td>{{$item->user->jabatan->subbagian->nama}} </td>
          <td> {{ masaKerja($item->user->tmt_masuk) }} </td>
          <td> {{ jenisCuti($item->jenis_cuti_id) }} </td>
          <td> {{$item->jumlah_hari}} </td>
          <td> {{Carbon::createFromFormat('Y-m-d', $item->mulai_cuti)->format('d-m-Y')}} </td>
          <td> {{Carbon::createFromFormat('Y-m-d', $item->akhir_cuti)->format('d-m-Y')}} </td>
          <td>
            <x-status-cuti status="{{$item->status_persetujuan_atasan_langsung}}" />
          </td>
          <td>
            <a href="{{route('atasan.approval.detail', $item->id)}}">
              <i class="fas fa-sign-in-alt"></i>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="12">
            <h6 class="text-center">No Data!</h6>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
  
@endsection