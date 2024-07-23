@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Daftar Lowongan -->
        <div class="col-md-4 border-end">
            <div class="list-group" id="lowonganList">
                @foreach ($lowongans as $lowongan)
                <a href="{{ route('peserta.registrasiForm', ['lowongan_id' => $lowongan->id]) }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center
                   @if(request('lowongan_id') == $lowongan->id) active @endif">
                    <img src="{{ $lowongan->mitra->getFirstMediaUrl('images') }}" alt="{{ $lowongan->name }}"
                        class="img-thumbnail me-3" style="width: 60px; height: 60px;">
                    <div>
                        <h5 class="mb-1">{{ $lowongan->name }}</h5>
                        <small>{{ $lowongan->mitra->name }}</small>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Detail Lowongan -->
        <div class="col-md-8">
            @if($selectedLowongan = $lowongans->where('id', request('lowongan_id'))->first())
            <div id="lowonganDetail" class="p-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="{{ $selectedLowongan->mitra->getFirstMediaUrl('images') }}" 
                                 id="mitraImage" class="rounded-circle me-3 img-4x" alt="Mitra Image"
                                style="width: 60px; height: 60px;" />
                            <div class="flex-grow-1">
                                <p id="lastUpdate" class="float-end text-info">{{ $selectedLowongan->updated_at->diffForHumans() }}</p>
                                <h6 id="mitraName" class="fw-bold">{{ $selectedLowongan->mitra->name }}</h6>
                                <p id="postTime" class="text-muted">{{ $selectedLowongan->created_at->diffForHumans() }}</p>
                                <p id="lowonganDescription">{{ $selectedLowongan->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">About</h5>
                    </div>
                    <div class="card-body">
                        <h6 id="mitraLocation" class="d-flex align-items-center mb-3">
                            <i class="bi bi-house fs-2 me-2"></i> Lokasi:
                            <span class="ms-2">{{ $selectedLowongan->location }}</span>
                        </h6>
                        <h6 class="d-flex align-items-center mb-3">
                            <i class="bi bi-building fs-2 me-2"></i> Mitra:
                            <span id="mitraWorks" class="text-primary ms-2">{{ $selectedLowongan->mitra->name }}</span>
                        </h6>
                        <h6 class="d-flex align-items-center mb-3">
                            <i class="bi bi-globe-americas fs-2 me-2"></i> Website:
                            <span id="mitraWebsite" class="text-primary ms-2">
                                <a href="{{ $selectedLowongan->mitra->website }}" target="_blank">{{ $selectedLowongan->mitra->website }}</a>
                            </span>
                        </h6>
                    </div>
                </div>
            </div>
            @else
            <div id="lowonganDetail" class="p-3">
                <p class="text-muted">Pilih salah satu lowongan untuk melihat detailnya.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
