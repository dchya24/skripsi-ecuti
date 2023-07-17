<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Formulir Pengajuan Cuti</title>
  <style>
    body {
      /* width: 210mm;
      height: 297mm;
      border: 1px solid #333; */
      padding: 0cm 1cm 1cm 1.25cm;
      box-sizing: border-box;
      font-family: Arial;
      font-size: 9pt;
      margin: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table tr td{
      border: 1px solid #000;
      margin: 0;
      padding: 0.15rem 0.3rem;
      min-height: 48px;
    }

    table {
      margin-top: 0.9rem;
    }
  </style>
</head>
<body>
  <h3 style="text-align: center; margin: 0;">FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</h3>

  {{-- Data Pegawai --}}
  <table>
    <tr>
      <td colspan="4">1. DATA PEGAWAI</td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>{{$userData->nama}}</td>
      <td>NIP</td>
      <td>{{$userData->nip}}</td>
    </tr>
    <tr>
      <td>Jabatan</td>
      <td>{{$userData->jabatan->nama}}</td>
      <td>Masa Kerja</td>
      <td>{{masaKerja($userData->tmt_masuk)}}</td>
    </tr>
    <tr>
      <td>Unit Kerja</td>
      <td colspan="3">{{$userData->jabatan->subbagian->nama}}</td>
    </tr>
  </table>

  {{-- Jenis Cuti --}}
  <table>
    <tr>
      <td colspan="4">
        II. JENIS CUTI YANG DIAMBIL**
      </td>
    </tr>
    <tr>
      <td>1. Cuti Tahunan</td>
      <td style="width: 5%; text-align: center;"> 
        <?php echo $perizinanCuti->jenis_cuti_id == $jenisCuti['CUTI_TAHUNAN'] ? 'v' : ''; ?> 
      </td>
      <td>2. Cuti Besar</td>
      <td style="width: 5%; text-align: center;">
        <?php echo $perizinanCuti->jenis_cuti_id == $jenisCuti['CUTI_BESAR'] ? 'v' : ''; ?>
      </td>
    </tr>
    <tr>
      <td>3. Cuti Sakit</td>
      <td style="text-align: center;">
        <?php echo $perizinanCuti->jenis_cuti_id == $jenisCuti['CUTI_SAKIT'] ? 'v' : ''; ?>
      </td>
      <td>4. Cuti Melahirkan</td>
      <td style="text-align: center;">
        <?php echo $perizinanCuti->jenis_cuti_id == $jenisCuti['CUTI_BERSALIN'] ? 'v' : ''; ?>
      </td>
    </tr>
    <tr>
      <td>5. Cuti Karena Alasan Penting</td>
      <td style="text-align: center;">
        <?php echo $perizinanCuti->jenis_cuti_id == $jenisCuti['CUTI_ALASAN_PENTING'] ? 'v' : ''; ?>
      </td>
      <td>5. Cuti Diluar Tanggungan Negara</td>
      <td style="text-align: center;">
        <?php echo $perizinanCuti->jenis_cuti_id == $jenisCuti['CUTI_DILUAR_TANGGUNGAN_NEGARA'] ? 'v' : ''; ?>
      </td>
    </tr>
  </table>

  {{-- Alasan Cuti --}}
  <table>
    <tr>
      <td>III. ALASAN CUTI</td>
    </tr>
    <tr>
      <td>{{$perizinanCuti->alasan_cuti}}</td>
    </tr>
  </table>

  {{-- Lama Cuti --}}
  <table>
    <tr>
      <td colspan="6">IV. LAMANYA CUTI</td>
    </tr>
    <tr>
      <td style="width: 15%;">Selama</td>
      <td style="width: 20%;"> {{$perizinanCuti->jumlah_hari}} Hari</td>
      <td style="width: 15%;">mulai tanggal</td>
      <td style="width: 20%;">{{$perizinanCuti->mulai_cuti}}</td>
      <td style="text-align: center; width: 5%">s/d</td>
      <td style="width: 20%;">{{$perizinanCuti->akhir_cuti}}</td>
    </tr>
  </table>

  {{-- Catatan Cuti --}}
  <table>
    <tr>
      <td colspan="5">IV. CATATAN CUTI***</td>
    </tr>
    <tr>
      <td colspan="3"> 1. CUTI TAHUNAN</td>
      <td style="width: 55%;">2. CUTI BESAR</td>
      <td style="width: 15%; text-align: center;">{{$historiCuti[0]->jumlah_cuti_besar}}</td>
    </tr>
    <tr>
      <td style="text-align: center">Tahun</td>
      <td style="text-align: center; width: 6%;">Sisa</td>
      <td style="text-align: center; width: 12%;">Keterangan</td>
      <td>3. CUTI SAKIT</td>
      <td style="text-align: center;">{{$historiCuti[0]->jumlah_cuti_sakit}}</td>
    </tr>
    <tr>
      <td>N ({{$historiCuti[0]->tahun}})</td>
      <td style="text-align: center">{{$historiCuti[0]->sisa_cuti_tahunan}}</td>
      <td></td>
      <td>4. CUTI MELAHIRKAN</td>
      <td style="text-align: center;">{{$historiCuti[0]->jumlah_cuti_melahirkan}}</td>
    </tr>
    <tr>
      <td>
        N-1
        @if(array_key_exists(1, $historiCuti->toArray()))
          ({{ $historiCuti[1]->tahun }})
        @endif
      </td>
      <td style="text-align: center">
        @if(array_key_exists(1, $historiCuti->toArray()))
          {{ $historiCuti[1]->sisa_cuti_tahunan }} 
        @endif
      </td>
      <td></td>
      <td>5. CUTI KARENA ALASAN PENTING</td>
      <td style="text-align: center;">{{$historiCuti[0]->jumlah_alasan_penting}}</td>
    </tr>
    <tr>
      <td> 
        N-2 
        @if(array_key_exists(2, $historiCuti->toArray()))
          ({{ $historiCuti[2]->tahun }})
        @endif
      </td>
      <td style="text-align: center">
        @if(array_key_exists(2, $historiCuti->toArray()))
          {{ $historiCuti[2]->sisa_cuti_tahunan }} 
        @endif
      </td>
      <td></td>
      <td>6. CUTI DI LUAR TANGGUNGAN NEGARA</td>
      <td style="text-align: center;">{{$historiCuti[0]->jumlah_tanggungan_diluar_negara}}</td>
    </tr>
  </table>

  {{-- Alamat Selama Menjalankan Cuti --}}
  <table>
    <tr>
      <td colspan="3">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
    </tr>
    <tr>
      <td style="width: 47%">{{$perizinanCuti->alamat_menjalankan_cuti}}</td>
      <td>TELP</td>
      <td>{{$perizinanCuti->no_telp}}</td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2" style="text-align: center; font-size: 9pt">
        Hormat Saya,
        <br><br><br>
        {{$userData->nama}} <br>
        NIP{{$userData->nip}}
      </td>
    </tr>
  </table>

  {{-- Pertimbangan Atasan Langsung --}}
  @if($perizinanCuti->atasan_langsung_id)
  <table>
    <tr>
      <td colspan="4">VII. PERTIMBANGAN ATASAN LANGSUNG</td>
    </tr>
    <tr>
      <td style="width: 22%">DISETUJUI</td>
      <td style="width: 22%">PERUBAHAN****</td>
      <td style="width: 22%">DITANGGUHKAN****</td>
      <td>TIDAK DISETUJUI****</td>
    </tr>
    <tr>
      @foreach($statusCuti as $status)
        <td>
          @if($perizinanCuti->status_persetujuan_atasan_langsung == $status)
              {{($perizinanCuti->alasan_persetujuan_atasan_langsung) ? $perizinanCuti->alasan_persetujuan_atasan_langsung : 'V'}}
              @elseif(!$perizinanCuti->status_persetujuan_atasan_langsung ||$perizinanCuti->status_persetujuan_atasan_langsung == 99)
            <span style="color: white">a</span>
          @endif
        </td>
      @endforeach
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>
        <br><br><br>
        {{$perizinanCuti->atasanLangsung->full_name}} 
        <br> 
        NIP {{$perizinanCuti->atasanLangsung->nip}} 
      </td>
    </tr>
  </table>
  @endif
  {{-- Keputusan Pejabat yang Berwenang Memberikan Cuti --}}
  <table>
    <tr>
      <td colspan="4">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI</td>
    </tr>
    <tr>
      <td style="width: 22%">DISETUJUI</td>
      <td style="width: 22%">PERUBAHAN****</td>
      <td style="width: 22%">DITANGGUHKAN****</td>
      <td>TIDAK DISETUJUI****</td>
    </tr>
    <tr>
      @foreach($statusCuti as $status)
        <td>
          @if($perizinanCuti->status_keputusan_pejabat_berwenang == $status)
            {{$perizinanCuti->alasan_keputusan_pejabat_berwenang}}
          @elseif(!$perizinanCuti->status_keputusan_pejabat_berwenang ||$perizinanCuti->status_keputusan_pejabat_berwenang == 99)
            <span style="color: white">a</span>
          @endif
        </td>
      @endforeach
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>
        <br><br><br>
        {{$perizinanCuti->pejabatBerwenang->full_name}} 
        <br> 
        NIP {{$perizinanCuti->pejabatBerwenang->nip}}
      </td>
    </tr>
  </table>

  
</body>
</html>