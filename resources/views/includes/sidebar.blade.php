@php
$items = [
[
'label' => 'Dashbord',
'url' => route('permission.index'),
'icon_class' => 'bi bi-box',
],
[
'label' => 'Manajemen Pengguna',
'url' => route('permission.index'),
'icon_class' => 'bi bi-box',
],

];
@endphp

<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper">
    <!-- Sidebar menu starts -->
    <div class="sidebarMenuScroll">
        <ul class="sidebar-menu">
            <li class="active current-page">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-box"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            @foreach ($items as $item)
            <li>
                <a href="{{ $item['url'] }}">
                    <i class="{{ $item['icon_class'] }}"></i>
                    <span class="menu-text">{{ $item['label'] }}</span>
                </a>
            </li>
            @endforeach
            <li class="treeview">
                <a href="#!">
                    <i class="bi bi-stickies"></i>
                    <span class="menu-text">Manajemen Pengguna</span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('permission.index') }}">Permissions</a>
                    </li>
                    <li>
                        <a href="{{ route('role.index') }}">Role</a>
                    </li>
                    <li>
                        <a href="{{ route('user.index') }}">Users</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{route('profile.edit')}}">
                    <i class="bi bi-box"></i>
                    <span class="menu-text">Profil(All User)</span>
                </a>
            </li>
            <li>
                <a href="{{ route('mitra.index') }}">
                    <i class="bi bi-box"></i>
                    <span class="menu-text">Mitra (Staff)</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dospem.index') }}">
                    <i class="bi bi-box"></i>
                    <span class="menu-text">Dosen Pembimbing (Staff)</span>
                </a>
            </li>
            <li>
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
<!-- Sidebar wrapper end -->
