@extends('template.app')
@section('title', 'Pengajuan Cuti')
@section('content')
  @if($errors->any())
    @foreach ($errors->all(0) as $error)
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{$error}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endforeach
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
    <a href="{{route('approval.index')}}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left"></i>
      Back
    </a>
    Perizinan Cuti
  </h5>

  <h6 class="border-bottom mt-2 py-3">Data Pegawai</h6>
  @include('component.table_pegawai')

  <div class="mt-2 py-2">
    <h6 class="py-3 border-bottom">Catatan Cuti</h6>
    <div class="row pt-3">
      <div class="col-md-2">
        Cuti Tahunan
      </div>
      <div class="col-md-3">
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
    <h6 class="py-3 border-bottom">Form Perizinan</h6>
    <form class="pt-4" method="POST" action="{{route('atasan.approval.approve')}}">
      <div class="form-group row">
        <label for="jenis_cuti" class="col-md-2 col-form-label">Jenis Cuti</label>
        <div class="col-md-8">
          : {{jenisCuti($data->jenis_cuti_id)}}
        </div>
      </div>

      <div class="form-group row">
        <label for="alasan" class="col-md-2 col-form-label">Alasan Cuti</label>
        <div class="col-md-8">
          : {{$data->alasan_cuti}}
        </div>
      </div>
      
      <div class="form-group row">
        <label for="bukti" class="col-md-2 col-form-label">Bukti</label>
        <div class="col-md-8">
          @if($data->bukti)
          : <a href="{{asset($data->bukti)}}" class="btn btn-sm btn-outline-primary">Lihat Bukti</a>
          @else
          : Tidak ada Bukti
          @endif
        </div>
      </div>
      
      <div class="form-group row">
        <label class="col-md-2 col-form-label">Tanggal</label>
        <div class="col-md-8">
            : {{ $data->mulai_cuti }}
            S/D
            {{ $data->akhir_cuti }}
        </div>
      </div>

      <div class="form-group row">
        <label for="lama" class="col-md-2 col-form-label">Jumlah Hari</label>
        <div class="col-md-3">
          : {{ $data->jumlah_hari }} Hari
        </div>
      </div>
  
      <div class="form-group row">
        <label for="alamat" class="col-md-2 col-form-label">Alamat Selama Cuti</label>
        <div class="col-md-8">
          : {{ $data->alamat_menjalankan_cuti }}
        </div>
      </div>
      
      <div class="form-group row">
        <label for="no_telp" class="col-md-2 col-form-label">No Telpon</label>
        <div class="col-md-8">
          : {{ $data->no_telp }}
        </div>
      </div>
      <div class="form-group row border-top pt-2">
        <label for="alasan_pertimbangan" class="col-md-2 col-form-label">Alasan Pertimbangan</label>
        <div class="col-md-8">
          <?php
            // $statusPejabat = ($data->status_keputusan_pejabat_berwenang != null ||$data->status_keputusan_pejabat_berwenang != 99);
            $statusPejabat = !in_array($data->status_keputusan_pejabat_berwenang, [null, 99]);
          ?>
          @foreach($statusCutiOptions as $key => $option)
            @if($key != 99)
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status-{{$key}}" value="{{$key}}" <?php echo ($key == $data->status_persetujuan_atasan_langsung) ? 'checked': ''; ?>  <?php echo $statusPejabat ? ' disabled' : '';?>>
                <label class="form-check-label" for="status-{{$key}}">
                  {{$option}}
                </label>
              </div>
            @endif
          @endforeach
          
          @if($statusPejabat)
            <br>
            <small id="" class="text-danger">
              Anda Tidak Bisa mengubah status pertimbangan karena sudah diberikan keputusan oleh pejabat berwenang!
            </small>
          @endif
        </div>
      </div>
      
      <div class="form-group row">
        <label for="alasan_pertimbangan" class="col-md-2 col-form-label">Alasan Pertimbangan</label>
        <div class="col-md-8">
          <textarea class="form-control" id="alasan_pertimbangan" rows="3" name="alasan_pertimbangan"></textarea>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-md-10 text-right">
          @csrf
          <input type="hidden" name="_id" value="{{$data->id}}">
          <button type="submit" class="btn btn-primary" <?php echo $statusPejabat ? 'disabled' : '';?>>
            Submit
            <i class="fas fa-paper-plane"></i>
          </button>
        </div>
      </div>

    </form>
  </div>
  
@endsection