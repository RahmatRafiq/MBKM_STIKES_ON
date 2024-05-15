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
                <a href="/dashboard">
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
                    <span class="menu-text">Profil</span>
                </a>
            </li>
            
        </ul>
    </div>
    <div class="sidebarMenuScroll">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="menu-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</nav>
<!-- Sidebar wrapper end -->