@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title">Daftar Registrasi</h2>
            {{-- <a href="{{ route('peserta.registrasiForm') }}" class="btn btn-primary">Form Registrasi</a> --}}
        </div>
        <div class="card-body">
            @foreach($registrations as $registration)
            <div class="card mb-3 shadow-sm" style="border-radius: 10px;">
                <div class="row g-0">
                    <!-- Bagian Gambar atau Placeholder -->
                    <div class="col-md-4 d-flex align-items-center justify-content-center"
                        style="border-radius: 10px 0 0 10px;">
                        <div class="text-center">
                            @if($registration->lowongan->mitra->image_url)
                            <img src="{{ $registration->lowongan->mitra->image_url }}" alt="Image Mitra"
                                class="img-fluid" style="border-radius: 10px; max-height: 200px;">
                            @else
                            <span class="text-muted">No Image Available</span>
                            @endif
                        </div>  
                    </div>

                    <!-- Bagian Deskripsi dan Konten -->
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title mb-2">ID Registrasi: {{ $registration->referensi }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <strong>{{ $registration->lowongan->mitra->name }}</strong>
                            </h6>
                            <h6 class="card-subtitle mb-2 text-muted">Nama Lowongan: {{ $registration->lowongan->name }}</h6>

                            <!-- Badge status -->
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

                            <!-- Progress Bar untuk Status -->
                            @php
                            $statusData = [
                                'registered' => ['percent' => 20, 'class' => 'custom-progress-bar-registered'],
                                'processed' => ['percent' => 40, 'class' => 'custom-progress-bar-processed'],
                                'accepted' => ['percent' => 60, 'class' => 'custom-progress-bar-accepted'],
                                'rejected' => ['percent' => 0, 'class' => 'custom-progress-bar-rejected'],
                                'rejected_by_user' => ['percent' => 0, 'class' => 'custom-progress-bar-rejected_by_user'],
                                'accepted_offer' => ['percent' => 80, 'class' => 'custom-progress-bar-accepted_offer'],
                                'placement' => ['percent' => 100, 'class' => 'custom-progress-bar-placement'],
                            ];
                            $currentStatus = $statusData[$registration->status] ?? ['percent' => 0, 'class' => 'bg-default'];
                            @endphp

                            <!-- Custom Progress Bar -->
                            <div class="custom-progress mb-2">
                                <div class="custom-progress-bar {{ $currentStatus['class'] }}" 
                                     style="width: {{ $currentStatus['percent'] }}%;">
                                </div>
                            </div>

                            <!-- Dosen Pembimbing -->
                            <p class="card-text mb-2">
                                <strong>Dosen Pembimbing:</strong>
                                @if($registration->status == 'placement' && $registration->dospem)
                                {{ $registration->dospem->name }}
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </p>

                            <!-- Tombol Aksi -->
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
