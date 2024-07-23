{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Registrasi Peserta</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $user = auth()->user();
                        $user->load('peserta')
                    @endphp
                    @foreach ($lowongans as $lowongan)
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4 class="card-title mb-2">{{ $lowongan->name }}</h4>
                                    <h6 class="card-subtitle text-muted mb-0">{{ $lowongan->mitra->type }}</h6>
                                </div>
                                <div class="card-body">
                                    <p>{{ $lowongan->description }}</p>
                                    <form action="{{ route('peserta.registrasi') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="peserta_id" value="{{ $user->peserta->id }}">
                                        <input type="hidden" name="lowongan_id" value="{{ $lowongan->id }}">
                                        <input type="hidden" name="nama_peserta" value="{{ $user->nama }}">
                                        <input type="hidden" name="nama_lowongan" value="{{ $lowongan->name }}">
                                        <button type="submit" class="btn btn-primary">Daftar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('registrasi.registrations-and-accept-offer', $user->id) }}" class="btn btn-info">Lihat Registrasi</a>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Registrasi Peserta</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $user = auth()->user();
                        $user->load('peserta')
                    @endphp
                    @foreach ($lowongans as $lowongan)
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4 class="card-title mb-2">{{ $lowongan->name }}</h4>
                                    <h6 class="card-subtitle text-muted mb-0">{{ $lowongan->mitra->type }}</h6>
                                </div>
                                <div class="card-body">
                                    @if ($lowongan->mitra->getMedia('images')->isNotEmpty())
                                        <img src="{{ $lowongan->mitra->getFirstMediaUrl('images') }}" alt="{{ $lowongan->mitra->name }}" class="img-fluid mb-3">
                                    @endif
                                    <p>{{ $lowongan->description }}</p>
                                    <form action="{{ route('peserta.registrasi') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="peserta_id" value="{{ $user->peserta->id }}">
                                        <input type="hidden" name="lowongan_id" value="{{ $lowongan->id }}">
                                        <input type="hidden" name="nama_peserta" value="{{ $user->nama }}">
                                        <input type="hidden" name="nama_lowongan" value="{{ $lowongan->name }}">
                                        <button type="submit" class="btn btn-primary">Daftar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('registrasi.registrations-and-accept-offer', $user->id) }}" class="btn btn-info">Lihat Registrasi</a>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Registrasi Peserta</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $user = auth()->user();
                        $user->load('peserta')
                    @endphp
                    @foreach ($lowongans as $lowongan)
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4 class="card-title mb-2">{{ $lowongan->name }}</h4>
                                    <h6 class="card-subtitle text-muted mb-0">{{ $lowongan->mitra->type }}</h6>
                                </div>
                                <div class="card-body">
                                    @if ($lowongan->mitra->getMedia('images')->isNotEmpty())
                                        <div id="carousel-{{ $lowongan->id }}" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach ($lowongan->mitra->getMedia('images') as $index => $image)
                                                    <div class="carousel-item @if ($index == 0) active @endif">
                                                        <img src="{{ $image->getUrl() }}" class="d-block w-100" alt="{{ $lowongan->mitra->name }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $lowongan->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $lowongan->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    @endif
                                    <p>{{ $lowongan->description }}</p>
                                    <form action="{{ route('peserta.registrasi') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="peserta_id" value="{{ $user->peserta->id }}">
                                        <input type="hidden" name="lowongan_id" value="{{ $lowongan->id }}">
                                        <input type="hidden" name="nama_peserta" value="{{ $user->nama }}">
                                        <input type="hidden" name="nama_lowongan" value="{{ $lowongan->name }}">
                                        <button type="submit" class="btn btn-primary">Daftar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('registrasi.registrations-and-accept-offer', $user->id) }}" class="btn btn-info">Lihat Registrasi</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
<!-- Add Bootstrap CSS for Carousel -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
@endpush

@push('javascript')
<!-- Add Bootstrap JS for Carousel -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
@endpush --}}
