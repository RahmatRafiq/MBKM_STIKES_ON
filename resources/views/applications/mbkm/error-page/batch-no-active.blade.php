@extends('layouts.app')

@section('title', config('app.name', 'Laravel') . ' - Akses Ditolak')

@section('content')

<body class="error-screen bg-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-9">
                <div class="d-flex align-items-center justify-content-center vh-100">
                    <div class="text-center">
                        <h1 class="error-title mb-3">403</h1>
                        <h3 class="mb-5">
                            Maaf, tidak ada batch aktif yang sedang berjalan.
                            <br>{{ $message ?? 'Anda tidak memiliki izin untuk melihat halaman ini.' }}
                        </h3>
                        <a href="{{ route('dashboard') }}" class="btn btn-warning px-5 py-3">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection