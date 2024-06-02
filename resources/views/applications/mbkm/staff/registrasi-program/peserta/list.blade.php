@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Daftar Registrasi</h2>
            <a href="{{ route('peserta.registrasiForm') }}" class="btn btn-primary">Form Registrasi</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID Registrasi</th>
                        <th>Nama Lowongan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $registration)
                    <tr>
                        <td>{{ $registration->id }}</td>
                        <td>{{ $registration->lowongan->name }}</td>
                        <td>{{ $registration->status }}</td>
                        <td>
                            @if($registration->status == 'accepted')
                            <form action="{{ route('peserta.acceptOffer', $registration->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Terima Tawaran</button>
                            </form>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
