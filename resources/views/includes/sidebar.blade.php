<nav id="sidebar" class="sidebar-wrapper">
    <!-- Sidebar menu starts -->
    <div class="sidebarMenuScroll custom-scrollbar">
        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('dashboard') ? 'active current-page' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> <!-- Ikon baru untuk Dashboard -->
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            @can ('manajemen_pengguna')
            <li class="treeview {{ request()->is('mbkm/admin/role-permissions*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-person-gear"></i> <!-- Ikon baru untuk Manajemen Pengguna -->
                    <span class="menu-text">Manajemen Pengguna</span>
                </a>
                <ul class="treeview-menu"
                    style="{{ request()->is('mbkm/admin/role-permissions*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ request()->routeIs('permission.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('permission.index') }}">Permissions</a>
                    </li>
                    <li class="{{ request()->routeIs('role.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('role.index') }}">Role</a>
                    </li>
                    <li class="{{ request()->routeIs('user.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('user.index') }}">Users</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('manajemen_aplikasi')

            <li class="treeview {{ request()->is('mbkm/manajemen-aplikasi*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-tools"></i>
                    <span class="menu-text">Manajemen Aplkasi</span>
                </a>
                <ul class="treeview-menu"
                    style="{{ request()->is('mbkm/manajemen-aplikasi*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ request()->routeIs('about-mbkms.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('about-mbkms.index') }}">Tentang MBKM</a>
                    </li>
                    <li class="{{ request()->routeIs('type-programs.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('type-programs.index') }}">Type Program</a>
                    </li>
                    <li class="{{ request()->routeIs('batch-mbkms.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('batch-mbkms.index') }}">Batch MBKM</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('manajemen_quisioner')
            <li class="treeview {{ request()->is('questionnaire*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-journal-check"></i> <!-- Ikon baru untuk Kuisioner -->
                    <span class="menu-text">Kuisioner</span>
                </a>
                <ul class="treeview-menu"
                    style="{{ request()->is('questionnaire*') ? 'display: block;' : 'display: none;' }}">
                    <li class="{{ request()->routeIs('questionnaire.participants') ? 'active-sub' : '' }}">
                        <a href="{{ route('questionnaire.participants') }}">Daftar Peserta & Detail Kuisioner</a>
                    </li>
                    <li class="{{ request()->routeIs('questions.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('questions.index') }}">Kelola Pertanyaan</a>
                    </li>
                </ul>
            </li>
            @endcan

            <li class="{{ request()->routeIs('profile.edit') ? 'active current-page' : '' }}">
                <a href="{{ route('profile.edit') }}">
                    <i class="bi bi-person"></i> <!-- Ikon baru untuk Profil -->
                    <span class="menu-text">Profil (All User)</span>
                </a>
            </li>

            @can('manajemen_mitra')
            <li class="{{ request()->routeIs('mitra.index') ? 'active current-page' : '' }}">
                <a href="{{ route('mitra.index') }}">
                    <i class="bi bi-briefcase"></i> <!-- Ikon baru untuk Mitra -->
                    <span class="menu-text">Mitra (Staff)</span>
                </a>
            </li>
            @endcan

            @can('manajemen_lowongan')
            <li class="{{ request()->routeIs('lowongan.index') ? 'active current-page' : '' }}">
                <a href="{{ route('lowongan.index') }}">
                    <i class="bi bi-clipboard-data"></i> <!-- Ikon baru untuk Lowongan -->
                    <span class="menu-text">Lowongan (Mitra)</span>
                </a>
            </li>
            @endcan

            @can('manajemen_dosen')
            <li class="{{ request()->routeIs('dospem.index') ? 'active current-page' : '' }}">
                <a href="{{ route('dospem.index') }}">
                    <i class="bi bi-person-check"></i> <!-- Ikon baru untuk Dosen Pembimbing -->
                    <span class="menu-text">Dosen Pembimbing (Staff)</span>
                </a>
            </li>
            @endcan

            @can('manajemen_peserta')
            <li class="{{ request()->routeIs('peserta.index') ? 'active current-page' : '' }}">
                <a href="{{ route('peserta.index') }}">
                    <i class="bi bi-people"></i> <!-- Ikon baru untuk Peserta -->
                    <span class="menu-text">Peserta (Staff)</span>
                </a>
            </li>
            @endcan

            @can('registrasi_program_mbkm')
            <li class="{{ request()->routeIs('registrasi.registrations-and-accept-offer') ? 'active current-page' : '' }}">
                <a href="{{ route('registrasi.registrations-and-accept-offer', ['id' => auth()->user()->peserta->id]) }}">
                    <i class="bi bi-file-earmark-plus"></i>
                    <span class="menu-text">Registrasi Peserta (Peserta)</span>
                </a>
            </li>
            @endcan
            

            @can('registrasi_program')
            <li class="{{ request()->routeIs('staff.registrasiIndex') ? 'active current-page' : '' }}">
                <a href="{{ route('staff.registrasiIndex') }}">
                    <i class="bi bi-card-checklist"></i> <!-- Ikon baru untuk Daftar Registrasi Peserta -->
                    <span class="menu-text">Daftar Registrasi Peserta (Staff)</span>
                </a>
            </li>
            @endcan

            @can('manajemen_laporan')
            <li class="treeview {{ request()->is('laporan*') ? 'active current-page open' : '' }}">

                <a href="#" class="treeview-toggle">
                    <i class="bi bi-journal-text"></i> <!-- Ikon baru untuk Laporan -->
                    <span class="menu-text">Laporan</span>
                </a>

                <ul class="treeview-menu"
                    style="{{ request()->is('laporan*') ? 'display: block;' : 'display: none;' }}">

                    @can ('view_laporan')
                    <li class="{{ request()->routeIs('laporan.index') ? 'active-sub' : '' }}">
                        <a href="{{ route('laporan.index') }}">Semua Laporan</a>
                    </li>
                    @endcan

                    @can('laporan_page')
                    <li class="{{ request()->routeIs('laporan.harian.create') ? 'active-sub' : '' }}">
                        <a href="{{ route('laporan.harian.create') }}">Laporan Harian</a>
                    </li>
                    <li class="{{ request()->routeIs('laporan.mingguan.create') ? 'active-sub' : '' }}">
                        <a href="{{ route('laporan.mingguan.create') }}">Laporan Mingguan</a>
                    </li>
                    <li class="{{ request()->routeIs('laporan.lengkap.create') ? 'active-sub' : '' }}">
                        <a href="{{ route('laporan.lengkap.create') }}">Laporan Lengkap</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @if(auth()->user()->peserta && auth()->user()->peserta->canAddTeamMember())
            <li class="{{ request()->routeIs('team.addMemberForm') ? 'active current-page' : '' }}">
                <a href="{{ route('team.addMemberForm', ['ketua' => auth()->user()->peserta->id]) }}">
                    <i class="bi bi-person-plus"></i> <!-- Ikon untuk Tambah Anggota Tim -->
                    <span class="menu-text">Tambah Anggota Tim (Peserta)</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</nav>