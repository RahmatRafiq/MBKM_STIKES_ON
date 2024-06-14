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
                        <th>Dosen Pembimbing</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $registration)
                    <tr>
                        <td>{{ $registration->id }}</td>
                        <td>{{ $registration->lowongan->name }}</td>
                        <td>
                            <span class="badge 
                                @if($registration->status == 'registered') badge-registered
                                @elseif($registration->status == 'processed') badge-processed
                                @elseif($registration->status == 'accepted') badge-accepted
                                @elseif($registration->status == 'rejected') badge-rejected
                                @elseif($registration->status == 'rejected_by_user') badge-rejected_by_user
                                @elseif($registration->status == 'accepted_offer') badge-accepted_offer
                                @elseif($registration->status == 'placement') badge-placement
                                @endif">
                                {{ $registration->status }}
                            </span>
                        </td>
                        <td>
                            @if($registration->status == 'placement' && $registration->dospem)
                            {{ $registration->dospem->name }}
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($registration->status == 'accepted')
                            <form action="{{ route('peserta.acceptOffer', $registration->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Terima Tawaran</button>
                            </form>
                            <form action="{{ route('peserta.rejectOffer', $registration->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Tolak Tawaran</button>
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

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/badges.css') }}">
@endpush