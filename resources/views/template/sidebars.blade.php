<button id="show-sidebar" class="btn btn-sm btn-dark">
  <i class="fas fa-bars"></i>
</button>
<nav id="sidebar" class="sidebar-wrapper">
  <div class="sidebar-content">
    <div class="sidebar-brand">
      <a href="#">
        <img src="{{asset('img/logo-dlh-small.png')}}" alt="Logo DLH DKI" class="img-fluid mr-1" style="width: 32px;">
        E-Cuti
      </a>
      <div id="close-sidebar">
        <i class="fas fa-times"></i>
      </div>
    </div>
    <div class="sidebar-header">
      {{-- <div class="user-pic">
        <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
          alt="User picture">
      </div> --}}
      <div class="user-info px-2">
        <span class="user-name">
          <strong>{{ Auth::user()->full_name }}</strong>
        </span>
        <span class="user-role">{{Auth::user()->jabatan->nama}}</span>
        {{-- <span class="user-status">
          <i class="fa fa-circle"></i>
          <span>Online</span>
        </span> --}}
      </div>
    </div>
    <!-- sidebar-header  -->
    <div class="sidebar-menu">
      <ul>
        <li class="header-menu @if($sidebar_menu === 'dashboard') active @endif">
          <a href="{{ route('dashboard')}}">
            <i class="fas fa-home"></i>
            Dashboard
          </a>
        </li>
        <li class="sidebar-dropdown @if($sidebar_menu === 'cuti') active @endif">
          <a href="#">
            <i class="fas fa-calendar-week"></i>
            Cuti
          </a>
          <div class="sidebar-submenu" @if($sidebar_menu === 'cuti') style="display: block;" @endif>
            <ul>
              <li @if($sidebar_submenu === 'cuti.add') class="active" @endif>
                <a href="{{ route('cuti.add') }}">Buat Perizinan</a>
              </li>
              <li @if($sidebar_submenu === 'cuti.index') class="active" @endif>
                <a href="{{route('cuti.index')}}">Riwayat Perizinan</a>
              </li>
            </ul>
          </div>
        </li>
        @if(!isStaff(Auth::user()->jabatan))
          <li class="sidebar-dropdown  @if($sidebar_menu === 'approval') active @endif">
            <a href="#">
              <i class="fas fa-tasks"></i>
              Approval Cuti Pegawai
            </a>
            <div class="sidebar-submenu" @if($sidebar_menu === 'approval') style="display: block;" @endif>
              <ul>
                <li @if($sidebar_submenu === 'approval.atasan') class="active" @endif>
                  <a href="{{route('approval.index')}}">Pertimbangan Atasan</a>
                </li>
                @if(isPejabatBerwenang(Auth::user()->jabatan))
                  <li @if($sidebar_submenu === 'approval.pejabat') class="active" @endif>
                    <a href="{{route('keputusan.index')}}">Keputusan Pejabat</a>
                  </li>
                @endif
              </ul>
            </div>
          </li>
        @endif

        @if(in_array(Auth::user()->jabatan_id, [13,14]))
        <li class="sidebar-dropdown  @if($sidebar_menu === 'kelola') active @endif">
          <a href="#">
            <i class="fas fa-address-book"></i>
            Administrator
          </a>
          <div class="sidebar-submenu"  @if($sidebar_menu === 'kelola') style="display: block;" @endif>
            <ul>
              <li @if($sidebar_submenu === 'kelola.pegawai') class="active" @endif>
                <a href="{{route('pegawai.index')}}">Kelola Pegawai</a>
              </li>
              <li @if($sidebar_submenu === 'kelola.jabatan') class="active" @endif>
                <a href="{{route('jabatan.index')}}">Kelola Jabatan</a>
              </li>
            </ul>
          </div>
        </li>
        @endif
        {{-- <li class="sidebar-dropdown">
          <a href="#">
            <i class="fa fa-tachometer-alt"></i>
            <span>Dashboard</span>
            <span class="badge badge-pill badge-warning">New</span>
          </a>
          <div class="sidebar-submenu">
            <ul>
              <li>
                <a href="#">Dashboard 1
                  <span class="badge badge-pill badge-success">Pro</span>
                </a>
              </li>
              <li>
                <a href="#">Dashboard 2</a>
              </li>
              <li>
                <a href="#">Dashboard 3</a>
              </li>
            </ul>
          </div>
        </li> --}}
      </ul>
    </div>
    <!-- sidebar-menu  -->
  </div>
  <!-- sidebar-content  -->
  <div class="sidebar-footer">
    {{-- <a href="#">
      <i class="fa fa-sign-out-alt"></i>
    </a> --}}
  </div>
</nav>