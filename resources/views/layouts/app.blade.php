<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <h2>C <span class="danger">BABAR</span> </h2>
                </div>
                <div class="close" id="close_btn">
                    <span class="material-symbols-sharp">close</span>
                </div>
            </div>
            <!-- end top -->
            <div class="sidebar">
                <a href="#">
                    <span class="material-symbols-sharp">grid_view</span>
                    <h3>Dashbord</h3>
                </a>
                <div class="submenu">
                    <a href="#">
                        <span class="material-symbols-sharp">grid_view</span>
                        <h3>Kampus Merdeka(staff)</h3>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">grid_view</span>
                        <h3>Kampus Mengajar(staff)</h3>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">grid_view</span>
                        <h3>Pertukaran Mahasiswa(staff)</h3>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">grid_view</span>
                        <h3>Dosen Pembimbing lapangan(staff)</h3>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">grid_view</span>
                        <h3>Mitra MBKM(staff)</h3>
                    </a>
                </div>
                <a href="#">
                    <span class="material-symbols-sharp">logout</span>
                    <h3>logout</h3>
                </a>
            </div>
            @include('layouts.navigation')
        </aside>
        {{ $slot }}
    </div>
    <script src="{{asset('assets/js/script.js')}}"></script>
</body>
</html>
