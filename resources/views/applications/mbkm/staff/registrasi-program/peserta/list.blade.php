@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title">Daftar Registrasi</h2>
            <a href="{{ route('peserta.registrasiForm') }}" class="btn btn-primary">Form Registrasi</a>
        </div>
        <div class="card-body">
            @foreach($registrations as $registration)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-2">ID Registrasi: {{ $registration->id }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted"><strong>{{ $registration->lowongan->mitra->name }}</strong></h6>
                    <h6 class="card-subtitle mb-2 text-muted">Nama Lowongan: {{ $registration->lowongan->name }} {{$registration->lowongan->mitra->name}}</h6>
                    <p class="card-text mb-2">
                        <strong>Status:</strong>
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
                    </p>
                    <p class="card-text mb-2">
                        <strong>Dosen Pembimbing:</strong>
                        @if($registration->status == 'placement' && $registration->dospem)
                        {{ $registration->dospem->name }}
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </p>
                    @if($registration->status == 'accepted')
                    <div class="d-flex justify-content-start mb-2">
                        <form action="{{ route('peserta.acceptOffer', $registration->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success me-2 mb-2">Terima Tawaran</button>
                        </form>
                        <form action="{{ route('peserta.rejectOffer', $registration->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger mb-2">Tolak Tawaran</button>
                        </form>
                    </div>
                    @else
                    <span class="text-muted mb-2">-</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/badges.css') }}">
@endpush
