@extends('layouts.app')

@section('content')
{{-- <div class="container-fluid"> --}}
    <div class="row gx-3">
        <!-- Daftar Lowongan -->
        <div class="col-xl-4 col-lg-12 border-end">
            <div class="list-group" id="lowonganList">
                @foreach ($lowongans as $lowongan)
                <a href="{{ route('peserta.registrasiForm', ['lowongan_id' => $lowongan->id]) }}" class="list-group-item list-group-item-action d-flex align-items-center
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
        <div class="col-xl-8 col-lg-12">
            @if($selectedLowongan = $lowongans->where('id', request('lowongan_id'))->first())
            <div id="lowonganDetail" class="p-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="{{ $selectedLowongan->mitra->getFirstMediaUrl('images') }}" id="mitraImage"
                                class="rounded-circle me-3 img-4x" alt="Mitra Image"
                                style="width: 60px; height: 60px;" />
                            <div class="flex-grow-1">
                                <p id="lowonganCreate" class="float-end text-info mb-1">{{
                                    $selectedLowongan->created_at->diffForHumans() }}</p>
                                <h6 id="mitraName" class="fw-bold mb-2">{{ $selectedLowongan->mitra->name }}</h6>
                                <h6 id="mitraName" class="fw-bold mb-2">{{ $selectedLowongan->name }}</h6>
                                <p>
                                    <i class="bi bi-file-text fs-5 me-2"></i> Deskripsi:
                                    <span id="lowonganDescription">{{ $selectedLowongan->description }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slider Gambar -->
                @if ($selectedLowongan->mitra->getMedia('images')->isNotEmpty())
                <div id="carouselExampleIndicators" class="carousel slide mb-3" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach ($selectedLowongan->mitra->getMedia('images') as $index => $image)
                        <button type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide-to="{{ $index }}" @if ($index==0) class="active" aria-current="true" @endif
                            aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ($selectedLowongan->mitra->getMedia('images') as $index => $image)
                        <div class="carousel-item @if ($index == 0) active @endif">
                            <img src="{{ $image->getUrl() }}" class="d-block w-100 carousel-image"
                                alt="{{ $selectedLowongan->mitra->name }}">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                @endif

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
                                <a href="{{ $selectedLowongan->mitra->website }}" target="_blank">{{
                                    $selectedLowongan->mitra->website }}</a>
                            </span>
                        </h6>
                        <p id="mitraDescription">{{ $selectedLowongan->mitra->description }}</p>
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

@push('head')
<!-- Add Bootstrap CSS for Carousel -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<style>
    .carousel-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
</style>
@endpush

@push('javascript')
<!-- Add Bootstrap JS for Carousel -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
@endpush
