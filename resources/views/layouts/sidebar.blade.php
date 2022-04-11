<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile border-bottom">
            <a href="#" class="nav-link flex-column">
                <div class="nav-profile-image">
                    <img src="{{ asset('template-admin') }}/assets/face1.jpg" alt="profile" />
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
                    <span
                        class="font-weight-semibold mb-1 mt-2 text-center">{{ strtoupper(Auth::user()->nama) }}</span>
                </div>
            </a>
        </li>
        <li class="pt-2 pb-1">
        </li>
        <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="mdi mdi-compass-outline menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if (Auth::user()->role == 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user') }}">
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                    <span class="menu-title">Karyawan</span>
                </a>
            </li>
            <li class="nav-item {{ Route::is('absen') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('absen') }}">
                    <i class="mdi mdi-calendar-text menu-icon"></i>
                    <span class="menu-title">Absensi</span>
                </a>
            </li>
            <li class="nav-item {{ Route::is('izin') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('izin') }}">
                    <i class="mdi mdi-calendar-text menu-icon"></i>
                    <span class="menu-title">
                        Pengajuan Izin
                        @php
                            $count = App\Models\Izin::where('status', 'proses')->count();
                        @endphp
                        @if ($count > 0)
                            <span class="badge badge-danger ml-0">{{ $count }}</span>
                        @endif
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="mdi mdi-calendar-text menu-icon"></i>
                    <span class="menu-title">Pengajuan Sakit
                        @php
                            $count = App\Models\Izin::where('status', 'proses')->count();
                        @endphp
                        @if ($count > 0)
                            <span class="badge badge-danger ml-0">{{ $count }}</span>
                        @endif
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('laporan.harian') }}">
                    <i class="mdi mdi-library-books menu-icon"></i>
                    <span class="menu-title">Laporan Harian</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('laporan.kunjungan') }}">
                    <i class="mdi mdi-library-books menu-icon"></i>
                    <span class="menu-title">Laporan Kunjungan</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
