<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
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
                    <span class="material-symbols-sharp">
                        close
                    </span>
                </div>
            </div>
            <!-- end top -->
            <div class="sidebar">

                <a href="#">
                    <span class="material-symbols-sharp">grid_view </span>
                    <h3>Dashbord</h3>
                </a>
                <a href="#" class="active">
                    <span class="material-symbols-sharp">person_outline </span>
                    <h3>custumers</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-sharp">insights </span>
                    <h3>Analytics</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-sharp">mail_outline </span>
                    <h3>Messages</h3>
                    <span class="msg_count">14</span>
                </a>
                <a href="#">
                    <span class="material-symbols-sharp">receipt_long </span>
                    <h3>Products</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-sharp">report_gmailerrorred </span>
                    <h3>Reports</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-sharp">settings </span>
                    <h3>settings</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-sharp">add </span>
                    <h3>Add Product</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-sharp">logout </span>
                    <h3>logout</h3>
                </a>
            </div>
        </aside>
        {{ $slot }}
    </div>
    <script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>
