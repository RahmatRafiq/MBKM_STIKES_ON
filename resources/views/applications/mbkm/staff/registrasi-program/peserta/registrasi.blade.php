@extends('layouts.app')

@section('content')
<div class="row gx-3" id="appContainer">
    <!-- Search and Filter -->
    <div class="col-12 mb-3" id="searchContainer">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <input type="text" id="searchBar" class="form-control me-2 mb-2 mb-sm-0 border border-primary" placeholder="Cari Lowongan...">
        </div>
        <div id="typeFilter" class="d-flex flex-wrap gap-2 mt-2">
            <button type="button" class="btn btn-outline-primary active" data-type="">Semua Tipe</button>
            @foreach ($types as $type)
            <button type="button" class="btn btn-outline-primary" data-type="{{ $type }}">{{ $type }}</button>
            @endforeach
        </div>
    </div>
    <!-- Tombol Kembali (di luar detail lowongan) -->
    <div class="col-12 mb-3">
        <button id="backButton" class="btn btn-primary d-none" onclick="showList()">Kembali</button>
    </div>
    <!-- Daftar Lowongan -->
    <div class="col-12 mb-3">
        <a href="{{ route('registrasi.registrations-and-accept-offer', ['id' => Auth::user()->id]) }}" class="btn btn-primary">Daftar Registrasi Anda</a>
    </div>
    <div class="col-md-4 col-sm-12 border-end" id="listContainer">
        <div class="list-group" id="lowonganList">
            @foreach ($lowongans as $lowongan)
            <a href="javascript:void(0);" class="list-group-item list-group-item-action d-flex align-items-center lowongan-item" data-id="{{ $lowongan->id }}" style="padding: 10px; border-bottom: 1px solid #ddd;">
                <div class="image-placeholder" data-src="{{ $lowongan->mitra->getFirstMediaUrl('images') }}" style="width: 60px; height: 60px; background: #f0f0f0; background-image: url('{{ $lowongan->mitra->getFirstMediaUrl('images') }}'); background-size: cover; background-position: center; margin-right: 15px;"></div>
                <div style="flex-grow: 1;">
                    <h5 style="margin: 0; margin-bottom: 5px; font-weight: bold;">{{ $lowongan->name }}</h5>
                    <h6 style="margin: 0; margin-bottom: 5px;">{{ $lowongan->mitra->type }}</h6>
                    <small style="margin: 0;">{{ $lowongan->mitra->name }}</small>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Detail Lowongan -->
    <div class="col-md-8 col-sm-12" id="detailContainer">
        <div id="lowonganDetail" class="col-md-12">
            <div class="card mb-3 d-none" id="detailCard">
                <div class="card-body" id="detailBody">
                    <!-- Detail content will be loaded here -->
                </div>
            </div>
            <div class="p-3" id="selectPrompt">
                <p class="text-muted">Pilih salah satu lowongan untuk melihat detailnya.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('head')
<style>
    @media (max-width: 768px) {
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
<script>
    let page = 1;
    let loading = false;

    function loadImages() {
        document.querySelectorAll('.image-placeholder').forEach(element => {
            const src = element.getAttribute('data-src');
            const img = new Image();
            img.src = src;
            img.onload = () => {
                element.style.backgroundImage = `url(${src})`;
                element.style.backgroundSize = 'cover';
                element.style.backgroundPosition = 'center';
            };
        });

        document.querySelectorAll('.carousel-image-placeholder').forEach(element => {
            const src = element.getAttribute('data-src');
            const img = new Image();
            img.src = src;
            img.onload = () => {
                element.style.backgroundImage = `url(${src})`;
                element.style.backgroundSize = 'cover';
                element.style.backgroundPosition = 'center';
            };
        });
    }

    function showDetail(id) {
        const width = window.innerWidth;
        $.ajax({
            url: "{{ route('peserta.registrasiForm') }}",
            method: 'GET',
            data: {
                lowongan_id: id,
                search: $('#searchBar').val(),
                sortByType: $('#typeFilter button.active').data('type')
            },
            success: function (response) {
                $('#detailBody').html(response.html);
                $('#detailCard').removeClass('d-none');
                $('#selectPrompt').addClass('d-none');
                loadImages();

                const newUrl = `${window.location.origin}${window.location.pathname}?lowongan_id=${id}`;
                window.history.pushState({ path: newUrl }, '', newUrl);

                if (width < 768) {
                    $('#searchContainer').hide();
                    $('#listContainer').hide();
                    $('#detailContainer').show();
                    $('#backButton').removeClass('d-none');
                }
            }
        });
    }

    function showList() {
        $('#searchContainer').show();
        $('#listContainer').show();
        $('#detailContainer').hide();
        $('#backButton').addClass('d-none');

        const newUrl = `${window.location.origin}${window.location.pathname}`;
        window.history.pushState({ path: newUrl }, '', newUrl);
    }

    function handleResize() {
        const width = window.innerWidth;
        const hasLowonganId = '{{ request('lowongan_id') }}' !== '';

        if (width >= 768) {
            $('#listContainer').show();
            $('#detailContainer').show();
            $('#backButton').addClass('d-none');
        } else {
            if (hasLowonganId) {
                $('#listContainer').hide();
                $('#detailContainer').show();
                $('#backButton').removeClass('d-none');
            } else {
                $('#listContainer').show();
                $('#detailContainer').hide();
                $('#backButton').addClass('d-none');
            }
        }
    }

    function loadDetailFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const lowonganId = urlParams.get('lowongan_id');
        if (lowonganId) {
            showDetail(lowonganId);
        }
    }

    function filterResults(page = 1) {
        let search = $('#searchBar').val();
        let type = $('#typeFilter button.active').data('type') || '';

        $.ajax({
            url: "{{ route('peserta.filter') }}",
            method: 'GET',
            data: {
                search: search,
                sortByType: type,
                page: page
            },
            success: function (data) {
                if (page === 1) {
                    $('#lowonganList').empty();
                }
                data.data.forEach(function (lowongan) {
                    $('#lowonganList').append(
                        `<a href="javascript:void(0);" class="list-group-item list-group-item-action d-flex align-items-center lowongan-item" data-id="${lowongan.id}">
                            <div class="image-placeholder" data-src="${lowongan.mitra.get_first_media_url}" style="width: 60px; height: 60px; background: #f0f0f0; margin-right: 15px;"></div>
                            <div>
                                <h5 class="mb-1" style="font-weight: bold;">${lowongan.name}</h5>
                                <h6 class="mb-1">${lowongan.mitra.type}</h6>
                                <small>${lowongan.mitra.name}</small>
                            </div>
                        </a>`
                    );
                });

                $('.lowongan-item').on('click', function () {
                    showDetail($(this).data('id'));
                });
                loadImages();
                loading = false; // Set loading to false after data is loaded
            }
        });
    }

    $(document).ready(function () {
        handleResize();
        window.addEventListener('resize', handleResize);

        $('#searchBar').on('input', function () {
            page = 1;
            filterResults();
        });

        $('#typeFilter button').on('click', function () {
            $('#typeFilter button').removeClass('active');
            $(this).addClass('active');
            page = 1;
            filterResults();
        });

        $('.lowongan-item').on('click', function () {
            showDetail($(this).data('id'));
        });

        $('#searchBar').val(new URLSearchParams(window.location.search).get('search') || '');
        $('#typeFilter button[data-type="' + new URLSearchParams(window.location.search).get('sortByType') + '"]').addClass('active');

        loadDetailFromURL();

        $('#lowonganList').on('scroll', function () {
            if (!loading && $(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight - 100) { // Tambahkan margin 100px sebelum akhir
                loading = true;
                page++;
                filterResults(page);
            }
        });
    });
</script>
@endpush
