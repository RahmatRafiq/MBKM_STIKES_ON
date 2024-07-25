@extends('layouts.app')

@section('content')
<div class="row gx-3" id="appContainer">
    <!-- Search and Filter -->
    <div class="col-12 mb-3" id="searchContainer">
        <div class="d-flex justify-content-between">
            <input type="text" id="searchBar" class="form-control" placeholder="Cari Lowongan...">
            <select id="typeFilter" class="form-control">
                <option value="">Semua Tipe</option>
                @foreach ($types as $type)
                <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <!-- Tombol Kembali (di luar detail lowongan) -->
    <div class="col-12 mb-3">
        <button id="backButton" class="btn btn-primary d-none" onclick="showList()">Kembali</button>
    </div>
    <!-- Daftar Lowongan -->
    <div class="col-md-4 col-sm-12 border-end" id="listContainer">
        <div class="list-group" id="lowonganList">
            @foreach ($lowongans as $lowongan)
            <a href="javascript:void(0);" class="list-group-item list-group-item-action d-flex align-items-center lowongan-item" data-id="{{ $lowongan->id }}">
                <div class="image-placeholder" data-src="{{ $lowongan->mitra->getFirstMediaUrl('images') }}" style="width: 60px; height: 60px; background: #f0f0f0;"></div>
                <div>
                    <h5 class="mb-1">{{ $lowongan->name }}</h5>
                    <small>{{ $lowongan->mitra->name }}</small>
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
                sortByType: $('#typeFilter').val()
            },
            success: function (response) {
                $('#detailBody').html(response.html);
                $('#detailCard').removeClass('d-none');
                $('#selectPrompt').addClass('d-none');
                loadImages();
                if (width < 768) {
                    $('#listContainer').hide();
                    $('#detailContainer').show();
                    $('#backButton').removeClass('d-none');
                }
            }
        });
    }

    function showList() {
        $('#listContainer').show();
        $('#detailContainer').hide();
        $('#backButton').addClass('d-none');
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

    $(document).ready(function () {
        handleResize();
        window.addEventListener('resize', handleResize);

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
                        $('#lowonganList').append(
                            `<a href="javascript:void(0);" class="list-group-item list-group-item-action d-flex align-items-center lowongan-item" data-id="${lowongan.id}">
                                <div class="image-placeholder" data-src="${lowongan.mitra.get_first_media_url}" style="width: 60px; height: 60px; background: #f0f0f0;"></div>
                                <div>
                                    <h5 class="mb-1">${lowongan.name}</h5>
                                    <small>${lowongan.mitra.name}</small>
                                </div>
                            </a>`
                        );
                    });

                    // Attach click event handler again
                    $('.lowongan-item').on('click', function () {
                        showDetail($(this).data('id'));
                    });
                    loadImages();
                }
            });
        });

        // Attach click event handler
        $('.lowongan-item').on('click', function () {
            showDetail($(this).data('id'));
        });

        // Set initial values of search bar and type filter based on URL parameters
        $('#searchBar').val(new URLSearchParams(window.location.search).get('search') || '');
        $('#typeFilter').val(new URLSearchParams(window.location.search).get('sortByType') || '');
    });
</script>
@endpush
