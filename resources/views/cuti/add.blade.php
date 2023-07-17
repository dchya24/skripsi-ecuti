@extends('template.app')
@section('title', 'Pengajuan Cuti')
@section('content')
  @if($errors->any())
    @foreach ($errors->all() as $error)
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

  <h5>Perizinan Cuti</h5>

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
  <form class="pt-4" method="POST" action="{{route('cuti.add.action')}}" enctype="multipart/form-data">
      <div class="form-group row">
        <label for="jenis_cuti" class="col-md-2 col-form-label">Jenis Cuti</label>
        <div class="col-md-8">
          <select class="form-control" id="jenis_cuti" name="jenis_cuti_id" required>
            <option value="">-</option>
            @foreach ($optionsJenisCuti as $key => $option)
                <option value="{{$key}}">{{$option}}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="alasan" class="col-md-2 col-form-label">Alasan Cuti</label>
        <div class="col-md-8">
          <textarea class="form-control" id="alasan" rows="3" name="alasan_cuti" required></textarea>
        </div>
      </div>
      
      <div class="form-group row">
        <label for="bukti" class="col-md-2 col-form-label">Bukti</label>
        <div class="col-md-8">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="bukti" name="bukti" accept="image/*|.pdf">
            <label class="custom-file-label" for="bukti">Choose file</label>
          </div>
          <small id="passwordHelpInline" class="text-muted">
            Tidak Wajib Diisi
          </small>
        </div>
      </div>
      
      <div class="form-group row">
        <label class="col-md-2 col-form-label">Tanggal</label>
        <div class="col-md-8 input-daterange row">
          <span class="input-group cuti-date col-md-4 pr-sm-0">
            <input class="form-control datepicker" type="text" id="start_date" name="mulai_cuti" placeholder="mm/dd/yyyy">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
            </div>
          </span>
          <div class="col-md-2 col-xl-1 align-items-center d-flex py-2">
            <span class="align-middle font-weight-bold m-sm-auto">S/D</span>
          </div>
          <span class="input-group cuti-date col-md-4 pl-sm-0">
            <input class="form-control datepicker" type="text" id="end_date" name="akhir_cuti" placeholder="mm/dd/yyyy">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
            </div>
          </span>
        </div>
      </div>

      <div class="form-group row">
        <label for="lama" class="col-md-2 col-form-label">Lamanya Cuti</label>
        <div class="col-md-3">
          <div class="input-group">
            <input type="number" class="form-control" id="lama" name="jumlah_hari" value="0" readonly>
            <div class="input-group-append">
              <span class="input-group-text font-weight-bold">Hari</span>
            </div>
          </div>
        </div>
      </div>
  
      <div class="form-group row">
        <label for="alamat" class="col-md-2 col-form-label">Alamat Selama Cuti</label>
        <div class="col-md-8">
          <textarea class="form-control" id="alamat" rows="3" name="alamat" required>{{Auth()->user()->alamat}}</textarea>
        </div>
      </div>
      
      <div class="form-group row">
        <label for="no_telp" class="col-md-2 col-form-label">No Telpon</label>
        <div class="col-md-8">
          <input type="number" class="form-control" id="no_telp" name="no_telp" value="{{Auth()->user()->no_telp}}" required>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-md-10 text-right">
          @csrf
          <button type="submit" class="btn btn-primary">
            Submit
            <i class="fas fa-paper-plane"></i>
          </button>
          <button type="reset" class="btn btn-outline-danger">Reset</button>
        </div>
      </div>
    </form>
  </div>
  
@endsection