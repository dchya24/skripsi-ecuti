@extends('template.app')
@section('title', 'DaftarCuti')
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
    Perizinan Cuti
  </h5>

  <form method="GET" class="form-inline">
    <select name="jenis_cuti" id="" class="form-control mr-1">
      <option value="all">Jenis Cuti</option>
      @foreach ($optionsJenisCuti as $key => $option)
          <option value="{{$key}}">{{$option}}</option>
      @endforeach
    </select>

    <select name="status_atasan" class="form-control mx-1">
      <option value="all">Status Atasan</option>
      @foreach ($statusCutiOptions as $key => $option)
          <option value="{{$key}}">{{$option}}</option>
      @endforeach
    </select>
    
    <select name="status_pejabat" class="form-control mx-1">
      <option value="all">Status Pejabat</option>
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
        <th>Jenis Cuti</th>
        <th>Jumlah Hari </th>
        <th>Mulai</th>
        <th>Akhir</th>
        <th>Status Atasan</th>
        <th>Status Pejabat</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($riwayat_cuti as $riwayat)
          <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td>{{$riwayat->created_at->format('d-m-Y')}}</td>
            <td>{{jenisCuti($riwayat->jenis_cuti_id)}}</td>
            <td>{{$riwayat->jumlah_hari}}</td>
            <td>{{$riwayat->mulai_cuti}}</td>
            <td>{{$riwayat->akhir_cuti}}</td>
            {{-- <td>{{statusCuti($riwayat->status_persetujuan_atasan_langsung)}}</td>
            <td>{{statusCuti($riwayat->status_keputusan_pejabat_berwenang)}}</td> --}}
            <td>
              <x-status-cuti status="{{$riwayat->status_persetujuan_atasan_langsung}}" />
            </td>
            <td>
              <x-status-cuti status="{{$riwayat->status_keputusan_pejabat_berwenang}}" />
            </td>
            <td>
              <a href="{{route('cuti.print', $riwayat->id)}}" class="btn btn-sm btn-outline-success">
                <i class="fas fa-print"></i>
              </a>
              <a href="{{route('cuti.show', $riwayat->id)}}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail dan Edit">
                <i class="fas fa-edit"></i>
              </a>
              @if($riwayat->status_persetujuan_atasan_langsung == 99 || $riwayat->status_persetujuan_atasan_langsung == null)
                <form action="{{route('cuti.delete')}}" method="POST" class="form d-inline">
                  @csrf
                  <input type="hidden" name="id" value={{$riwayat->id}}>
                  <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus atau Batalkan pengajuan cuti">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>
              @endif
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
  
@endsection