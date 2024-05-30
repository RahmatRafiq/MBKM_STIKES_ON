<nav id="sidebar" class="sidebar-wrapper">
    <!-- Sidebar menu starts -->
    <div class="sidebarMenuScroll">
        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('dashboard') ? 'active current-page' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-box"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li class="treeview {{ request()->is('mbkm/admin/role-permissions*') ? 'active current-page open' : '' }}">
                <a href="#" class="treeview-toggle">
                    <i class="bi bi-stickies"></i>
                    <span class="menu-text">Manajemen Pengguna</span>
                </a>
                <ul class="treeview-menu" style="{{ request()->is('mbkm/admin/role-permissions*') ? 'display: block;' : 'display: none;' }}">
                    <li>
                        <a href="{{ route('permission.index') }}" class="{{ request()->routeIs('permission.index') ? 'active-sub' : '' }}">Permissions</a>
                    </li>
                    <li>
                        <a href="{{ route('role.index') }}" class="{{ request()->routeIs('role.index') ? 'active-sub' : '' }}">Role</a>
                    </li>
                    <li>
                        <a href="{{ route('user.index') }}" class="{{ request()->routeIs('user.index') ? 'active-sub' : '' }}">Users</a>
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
                    <span class="menu-text">Peserta(Staff)</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('peserta.registrasiForm') ? 'active current-page' : '' }}">
                <a href="{{ route('peserta.registrasiForm') }}">
                    <i class="bi bi-box"></i>
                    <span class="menu-text">Registrasi Peserta(Peserta)</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('staff.registrasiIndex') ? 'active current-page' : '' }}">
                <a href="{{ route('staff.registrasiIndex') }}">
                    <i class="bi bi-box"></i>
                    <span class="menu-text">Daftar Registrasi Peserta(Staff)</span>
                </a>
            </li>
          
        </ul>
    </div>
</nav>

