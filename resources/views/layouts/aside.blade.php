@php
    $path = explode('/', Request::path());
    $role = auth()->user()->role;

    $dashboardRoutes = [
        'admin' => 'admin.dashboard-admin',
        'guru' => 'guru.dashboard-guru',
        // 'mahasiswa' => 'mahasiswa.dashboard-mahasiswa',
    ];

    $isActive = in_array($role, array_keys($dashboardRoutes)) && isset($path[1]) && $path[1] === 'dashboard-' . $role;
    $activeColor = $isActive ? 'color: #F4BE2A' : 'color: #FFFFFF';
@endphp

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route($dashboardRoutes[$role]) }}" class="nav-link {{ $isActive ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            @if ($role == 'admin')
                <li class="nav-header">Data Master</li>
                <li class="nav-item">
                    <a href="{{ route('admin.data-guru') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-guru' ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher nav-icon"></i>
                        <p>Data Guru</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.data-siswa') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-siswa' ? 'active' : '' }}">
                        <i class="fas fa-user-graduate nav-icon"></i>
                        <p>Data Siswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.data-mapel') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-mapel' ? 'active' : '' }}">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Mata Pelajaran</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.data-tahunajaran') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-tahunajaran' ? 'active' : '' }}">
                        <i class="fas fa-calendar nav-icon"></i>
                        <p>Tahun Ajaran</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.data-akademik') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-akademik' ? 'active' : '' }}">
                        <i class="fas fa-university nav-icon"></i>
                        <p>Data Akademik</p>
                    </a>
                </li>
                <li class="nav-header">Gramifikasi</li>
                <li class="nav-item">
                    <a href="{{ route('admin.data-misi') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-misi' ? 'active' : '' }}">
                        <i class="fas fa-search nav-icon"></i>
                        <p>Data Misi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.data-lencana') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-lencana' ? 'active' : '' }}">
                        <i class="fas fa-medal nav-icon"></i>
                        <p>Data Lencana</p>
                    </a>
                </li>
                <li class="nav-header">Pembelajaran</li>
                <li class="nav-item">
                    <a href="{{ route('admin.data-kategori') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-kategori' ? 'active' : '' }}">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Data Kategori</p>
                    </a>
                </li>
                <li class="nav-header">Data Forum</li>
                <li class="nav-item">
                    <a href="{{ route('admin.data-forum') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-forum' ? 'active' : '' }}">
                        <i class="fas fa-bell nav-icon"></i>
                        <p>Forum</p>
                    </a>
                </li>
            @endif

            @if ($role == 'guru')
                <li class="nav-header">Absensi</li>
                <li class="nav-item">
                    <a href="{{ route('guru.data-absen') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-absen' ? 'active' : '' }}">
                        <i class="fas fa-file-powerpoint nav-icon"></i>
                        <p>Data Absen</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('guru.rekap-absen') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'rekap-absen' ? 'active' : '' }}">
                        <i class="fas fa-file nav-icon"></i>
                        <p>Rekap Ansen</p>
                    </a>
                </li>
                <li class="nav-header">Gramifikasi</li>
                <li class="nav-item">
                    <a href="{{ route('guru.data-soal') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-soal' ? 'active' : '' }}">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Data Soal</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('guru.penilaian-gramifikasi') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'penilaian-gramifikasi' ? 'active' : '' }}">
                        <i class="fas fa-file nav-icon"></i>
                        <p>Penilaian</p>
                    </a>
                </li>
                <li class="nav-header">Pembelajaran</li>
                <li class="nav-item">
                    <a href="{{ route('guru.data-soalpembelajaran') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'data-soalpembelajaran' ? 'active' : '' }}">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Data Soal</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('guru.penilaian-pembelajaran') }}"
                        class="nav-link {{ isset($path[1]) && $path[1] === 'penilaian-pembelajaran' ? 'active' : '' }}">
                        <i class="fas fa-file nav-icon"></i>
                        <p>Penilaian</p>
                    </a>
                </li>
            @endif

            <li class="nav-header">
                <hr class="bg-white">
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link bg-danger">
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
