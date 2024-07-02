<head>
    <style>
        .custom-scrollbar {
            height: calc(100vh - 20px);
            /* Sesuaikan jika diperlukan */
            overflow-y: auto;
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
    <nav id="sidebar" class="sidebar-wrapper">
        <!-- Sidebar menu starts -->
        <div class="sidebarMenuScroll custom-scrollbar">
            <ul class="sidebar-menu">
                <li class="{{ request()->routeIs('dashboard') ? 'active current-page' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="bi bi-box"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                {{-- //admindashboard --}}
                <li class="{{ request()->routeIs('dashboard.admin') ? 'active current-page' : '' }}">
                    <a href="{{ route('dashboard.admin') }}">
                        <i class="bi bi-box"></i>
                        <span class="menu-text">Admin Dashboard</span>
                    </a>
                <li
                    class="treeview {{ request()->is('mbkm/admin/role-permissions*') ? 'active current-page open' : '' }}">
                    <a href="#" class="treeview-toggle">
                        <i class="bi bi-stickies"></i>
                        <span class="menu-text">Manajemen Pengguna</span>
                    </a>
                    <ul class="treeview-menu"
                        style="{{ request()->is('mbkm/admin/role-permissions*') ? 'display: block;' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('permission.index') }}"
                                class="{{ request()->routeIs('permission.index') ? 'active-sub' : '' }}">Permissions</a>
                        </li>
                        <li>
                            <a href="{{ route('role.index') }}"
                                class="{{ request()->routeIs('role.index') ? 'active-sub' : '' }}">Role</a>
                        </li>
                        <li>
                            <a href="{{ route('user.index') }}"
                                class="{{ request()->routeIs('user.index') ? 'active-sub' : '' }}">Users</a>
                        </li>
                        <li>
                            <a href="{{ route('about-mbkms.index') }}"
                                class="{{ request()->routeIs('about-mbkms.index') ? 'active-sub' : '' }}">About MBKM</a>
                        </li>
                        <li>
                            <a href="{{ route('batch-mbkms.index') }}"
                                class="{{ request()->routeIs('batch-mbkms.index') ? 'active-sub' : '' }}">Batch MBKM</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->routeIs('profile.edit') ? 'active current-page' : '' }}">
                    <a href="{{ route('profile.edit') }}">
                        <i class="bi bi-box"></i>
                        <span class="menu-text">Profil (All User)</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('mitra.index') ? 'active current-page' : '' }}">
                    <a href="{{ route('mitra.index') }}">
                        <i class="bi bi-box"></i>
                        <span class="menu-text">Mitra (Staff)</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('dospem.index') ? 'active current-page' : '' }}">
                    <a href="{{ route('dospem.index') }}">
                        <i class="bi bi-box"></i>
                        <span class="menu-text">Dosen Pembimbing (Staff)</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('lowongan.index') ? 'active current-page' : '' }}">
                    <a href="{{ route('lowongan.index') }}">
                        <i class="bi bi-box"></i>
                        <span class="menu-text">Lowongan (Mitra)</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('peserta.index') ? 'active current-page' : '' }}">
                    <a href="{{ route('peserta.index') }}">
                        <i class="bi bi-box"></i>
                        <span class="menu-text">Peserta (Staff)</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('peserta.registrasiForm') ? 'active current-page' : '' }}">
                    <a href="{{ route('peserta.registrasiForm') }}">
                        <i class="bi bi-box"></i>
                        <span class="menu-text">Registrasi Peserta (Peserta)</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.registrasiIndex') ? 'active current-page' : '' }}">
                    <a href="{{ route('staff.registrasiIndex') }}">
                        <i class="bi bi-box"></i>
                        <span class="menu-text">Daftar Registrasi Peserta (Staff)</span>
                    </a>
                </li>
                <li class="treeview {{ request()->is('laporan*') ? 'active current-page open' : '' }}">
                    <a href="#" class="treeview-toggle">
                        <i class="bi bi-file-earmark-text"></i>
                        <span class="menu-text">Laporan</span>
                    </a>
                    <ul class="treeview-menu"
                        style="{{ request()->is('laporan*') ? 'display: block;' : 'display: none;' }}">
                        <li>
                            <a href="{{ route('laporan.index') }}"
                                class="{{ request()->routeIs('laporan.index') ? 'active-sub' : '' }}">Semua Laporan</a>
                        </li>
                        <li>
                            <a href="{{ route('laporan.harian.create') }}"
                                class="{{ request()->routeIs('laporan.harian.create') ? 'active-sub' : '' }}">Laporan
                                Harian</a>
                        </li>
                        <li>
                            <a href="{{ route('laporan.mingguan.create') }}"
                                class="{{ request()->routeIs('laporan.mingguan.create') ? 'active-sub' : '' }}">Laporan
                                Mingguan</a>
                        </li>
                        <li>
                            <a href="{{ route('laporan.lengkap.create') }}"
                                class="{{ request()->routeIs('laporan.lengkap.create') ? 'active-sub' : '' }}">Laporan
                                Lengkap</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</body>

</html>