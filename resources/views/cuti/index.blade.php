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

  <h5>Perizinan Cuti</h5>

  <table class="table table-striped table-bordered mt-4">
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal Pengajuan</th>
        <th>Jenis Cuti</th>
        <th>Jumlah Hari </th>
        <th>Mulai</th>
        <th>Akhir</th>
        <th>Status Alasan</th>
        <th>Status Pejabat</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($riwayat_cuti as $riwayat)
          <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td>{{$riwayat->created_at}}</td>
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
              <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail dan Edit">
                <i class="fas fa-edit"></i>
              </a>
              <form action="{{route('cuti.delete')}}" method="POST" class="form d-inline">
                @csrf
                <input type="hidden" name="id" value={{$riwayat->id}}>
                <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Data">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </td>
          </tr>
      @endforeach
    </tbody>
  </table>
  
@endsection