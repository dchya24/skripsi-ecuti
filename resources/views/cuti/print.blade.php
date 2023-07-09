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
      <td>Nama User</td>
      <td>NIP</td>
      <td>00980132</td>
    </tr>
    <tr>
      <td>Jabatan</td>
      <td>Apa</td>
      <td>Masa Kerja</td>
      <td>Kerja</td>
    </tr>
    <tr>
      <td>Unit Kerja</td>
      <td colspan="3">Unit Kerja</td>
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
      <td style="width: 5%;"> 0 </td>
      <td>2. Cuti Besar</td>
      <td style="width: 5%;"> 0 </td>
    </tr>
    <tr>
      <td>3. Cuti Sakit</td>
      <td>0</td>
      <td>4. Cuti Melahirkan</td>
      <td>0</td>
    </tr>
    <tr>
      <td>5. Cuti Karena Alasan Penting</td>
      <td>0</td>
      <td>5. Cuti Diluar Tanggungan Negara</td>
      <td>0</td>
    </tr>
  </table>

  {{-- Alasan Cuti --}}
  <table>
    <tr>
      <td>III. ALASAN CUTI</td>
    </tr>
    <tr>
      <td>Sakit</td>
    </tr>
  </table>

  {{-- Lama Cuti --}}
  <table>
    <tr>
      <td colspan="6">IV. LAMANYA CUTI</td>
    </tr>
    <tr>
      <td style="width: 15%;">Selama</td>
      <td style="width: 20%;">Hari</td>
      <td style="width: 15%;">mulai tanggal</td>
      <td style="width: 20%;">01/01/2001</td>
      <td style="text-align: center; width: 5%">s/d</td>
      <td style="width: 20%;">01/01/2001</td>
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
      <td style="width: 15%; text-align: center;">0</td>
    </tr>
    <tr>
      <td style="text-align: center">Tahun</td>
      <td style="text-align: center">Sisa</td>
      <td style="text-align: center">Keterangan</td>
      <td>3. CUTI SAKIT</td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>4. CUTI MELAHIRKAN</td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>5. CUTI KARENA ALASAN PENTING</td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>6. CUTI DI LUAR TANGGUNGAN NEGARA</td>
      <td></td>
    </tr>
  </table>

  {{-- Alamat Selama Menjalankan Cuti --}}
  <table>
    <tr>
      <td colspan="3">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
    </tr>
    <tr>
      <td style="width: 47%">Alamat Dongkal ddkk</td>
      <td>TELP</td>
      <td>0819324</td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2" style="text-align: center; font-size: 10pt">
        Hormat Saya,
        <br><br><br>
        Cahya Dinar <br>
        NIP 0908132
      </td>
    </tr>
  </table>

  {{-- Pertimbangan Atasan Langsung --}}
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
      <td style="color: #fff">a</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>
        <br><br><br>
        Nama 
        <br> 
        NIP 
      </td>
    </tr>
  </table>

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
      <td style="color: #fff">a</td>
      <td> </td>
      <td> </td>
      <td> </td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>
        <br><br><br>
        Nama 
        <br> 
        NIP 
      </td>
    </tr>
  </table>

  
</body>
</html>