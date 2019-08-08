<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
        <div class="nav-link d-flex">
            <div class="profile-image">
                @hasrole('pasien')
                <img src="{{ asset('images/avatar/'.\Auth::user()->load('pasien')->pasien->avatar) }}" alt="image"/>
                @else
                <img src="{{ asset('images/avatar/default.png')}}" alt="image"/>
                @endhasrole
            <span class="online-status online"></span> <!--change class online to offline or busy as needed-->
            </div>
            <div class="profile-name">
            <p class="name">
                @hasanyrole('admin|perawat|pegawai')
                    {{\Auth::user()->name}}
                @else
                {{\Auth::user()->load('pasien')->pasien->nama_lengkap}}
                @endhasanyrole

            </p>
            <p class="designation">
                    {{\Auth::user()->getRoleNames()->first()}}
            </p>
            </div>
        </div>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{route('home.index')}}">
            <i class="icon-layers menu-icon"></i>
            <span class="menu-title">Antrian</span>
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{route('antrian.index')}}">
            <i class="icon-layers menu-icon"></i>
            <span class="menu-title">Antrian Dokter</span>
        </a>
        </li>
        @hasrole('pasien')
        <li class="nav-item">
        <a class="nav-link" href="{{route('profile.index')}}">
            <i class="icon-user menu-icon"></i>
            <span class="menu-title">Profile</span>
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{route('master-asuransi-pasien.index')}}">
            <i class="icon-user menu-icon"></i>
            <span class="menu-title">Asuransi</span>
        </a>
        </li>
        @endhasrole
        <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts" aria-expanded="false" aria-controls="sidebar-layouts">
            <i class="icon-globe menu-icon"></i>
            <span class="menu-title">Master</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="sidebar-layouts">
            <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('master-dokter.index') }}">Master Dokter</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('master-spesialis.index') }}">Master Spesialis</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('master-asuransi.index') }}">Master Asuransi</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('master-jadwal-dokter.index') }}">Master Jadwal Dokter</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('master-user.index') }}">Master Users</a></li>
            </ul>
        </div>
        </li>
    </ul>
</nav>
