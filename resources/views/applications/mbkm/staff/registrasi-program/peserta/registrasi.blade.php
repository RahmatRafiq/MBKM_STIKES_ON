@extends('layouts.app')

@section('content')
<div class="row gx-3" id="appContainer">
    <!-- Search and Filter -->
    <div class="col-12 mb-3">
        <div class="d-flex justify-content-between">
            <input type="text" id="searchBar" class="form-control w-50" placeholder="Cari Lowongan...">
            <select id="typeFilter" class="form-control w-25">
                <option value="">Semua Tipe</option>
                @foreach ($types as $type)
                <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <!-- Daftar Lowongan -->
    <div class="col-xl-4 col-lg-12 border-end" id="listContainer">
        <div class="list-group" id="lowonganList">
            @foreach ($lowongans as $lowongan)
            <a href="?lowongan_id={{ $lowongan->id }}&search={{ request('search') }}&sortByType={{ request('sortByType') }}" class="list-group-item list-group-item-action d-flex align-items-center
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
    <div class="col-xl-8 col-lg-12" id="detailContainer">
        <button id="backButton" class="btn btn-primary mb-3" onclick="showList()">Kembali</button>
        @if($selectedLowongan = $lowongans->where('id', request('lowongan_id'))->first())
        <div id="lowonganDetail" class="p-3">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex">
                        <img src="{{ $selectedLowongan->mitra->getFirstMediaUrl('images') }}" id="mitraImage"
                            class="rounded-circle me-3 img-4x" alt="Mitra Image" style="width: 60px; height: 60px;" />
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
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}"
                        @if ($index==0) class="active" aria-current="true" @endif
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
@endsection

@push('head')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<style>
    .carousel-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    #detailContainer {
        display: none;
    }

    #backButton {
        display: none;
    }

    @media (min-width: 1440px) {
        #listContainer {
            display: block;
            overflow-y: auto;
            max-height: 90vh;
        }

        #detailContainer {
            display: block;
        }

        #backButton {
            display: none;
        }
    }

    @media (max-width: 1440px) {
        #listContainer {
            display: none;
        }

        #detailContainer {
            display: block;
        }

        #backButton {
            display: block;
        }
    }
</style>
@endpush

@push('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script>
    function showDetail(id) {
        const width = window.innerWidth;
        if (width < 1440) {
            document.getElementById('listContainer').style.display = 'none';
            document.getElementById('detailContainer').style.display = 'block';
            document.getElementById('backButton').style.display = 'block';
        }
    }

    function showList() {
        document.getElementById('listContainer').style.display = 'block';
        document.getElementById('detailContainer').style.display = 'none';
        document.getElementById('backButton').style.display = 'none';
    }

    window.addEventListener('resize', function () {
        const width = window.innerWidth;
        if (width >= 1440) {
            document.getElementById('listContainer').style.display = 'block';
            document.getElementById('detailContainer').style.display = 'block';
            document.getElementById('backButton').style.display = 'none';
        } else {
            document.getElementById('listContainer').style.display = 'none';
            document.getElementById('detailContainer').style.display = 'block';
            document.getElementById('backButton').style.display = 'block';
        }
    });

    $(document).ready(function () {
        $('#searchBar, #typeFilter').on('input change', function () {
            let search = $('#searchBar').val();
            let type = $('#typeFilter').val();

            $.ajax({
                url: "{{ route('peserta.filter') }}",
                method: 'GET',
                data: {
                    search: search,
                    sortByType: type
                },
                success: function (data) {
                    $('#lowonganList').empty();
                    data.forEach(function (lowongan) {
                        let activeClass = '{{ request('lowongan_id') }}' == lowongan.id ? 'active' : '';
                        $('#lowonganList').append(`
                            <a href="?lowongan_id=${lowongan.id}&search=${search}&sortByType=${type}" class="list-group-item list-group-item-action d-flex align-items-center ${activeClass}">
                                <img src="${lowongan.mitra.get_first_media_url}" alt="${lowongan.name}" class="img-thumbnail me-3" style="width: 60px; height: 60px;">
                                <div>
                                    <h5 class="mb-1">${lowongan.name}</h5>
                                    <small>${lowongan.mitra.name}</small>
                                </div>
                            </a>
                        `);
                    });
                }
            });
        });

        // Set initial values of search bar and type filter based on URL parameters
        $('#searchBar').val(new URLSearchParams(window.location.search).get('search') || '');
        $('#typeFilter').val(new URLSearchParams(window.location.search).get('sortByType') || '');
    });
</script>
@endpush
