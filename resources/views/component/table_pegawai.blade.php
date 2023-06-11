<table class="table table-borderless w-75">
  <tr>
    <td class="pl-0">Nama</td>
    <td>{{Auth::user()->nama}}</td>
  </tr>
  <tr>
    <td class="pl-0">NIP</td>
    <td>{{Auth::user()->nip}}</td>
  </tr>
  <tr>
    <td class="pl-0">Masa Kerja</td>
    <td>{{masaKerja(Auth::user()->tmt_masuk)}}</td>
  </tr>
  <tr>
    <td class="pl-0">Unit Kerja</td>
    <td>{{Auth::user()->jabatan->subbagian->nama}}</td>
  </tr>
</table>