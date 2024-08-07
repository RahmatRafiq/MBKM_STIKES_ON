@extends('layouts.app')

@section('content')
<div class="row gx-3">
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card mb-3 card-custom background-gradient-1">
            <div class="card-body">
                <div class="circle-shape shape-1"></div>
                <div class="circle-shape shape-2"></div>
                <div class="circle-shape shape-3"></div>
                <div class="mb-2">
                    <i class="bi bi-file-earmark-text fs-1 text-white lh-1"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="m-0 text-white fw-normal">Laporan Harian</h5>
                    <h3 class="m-0 text-white">{{ $laporanHarian }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card mb-3 card-custom background-gradient-2">
            <div class="card-body">
                <div class="circle-shape shape-1"></div>
                <div class="circle-shape shape-2"></div>
                <div class="circle-shape shape-3"></div>
                <div class="mb-2">
                    <i class="bi bi-calendar-week fs-1 text-white lh-1"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="m-0 text-white fw-normal">Laporan Mingguan</h5>
                    <h3 class="m-0 text-white">{{ $laporanMingguan }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card mb-3 card-custom background-gradient-3">
            <div class="card-body">
                <div class="circle-shape shape-1"></div>
                <div class="circle-shape shape-2"></div>
                <div class="circle-shape shape-3"></div>
                <div class="mb-2">
                    <i class="bi bi-person fs-1 text-white lh-1"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="m-0 text-white fw-normal">Laporan Lengkap</h5>
                    <h3 class="m-0 text-white">{{ $laporanLengkap }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card mb-3 card-custom background-gradient-4">
            <div class="card-body">
                <div class="circle-shape shape-1"></div>
                <div class="circle-shape shape-2"></div>
                <div class="circle-shape shape-3"></div>
                <div class="mb-2">
                    <i class="bi bi-briefcase fs-1 text-white lh-1"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="m-0 text-white fw-normal">Lowongan Tersedia</h5>
                    <h3 class="m-0 text-white">{{ $lowonganTersedia }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 col-12">
        <div class="card mb-3 card-custom background-gradient-7">
            <div class="card-header">
                <h5 class="card-title text-black">Peserta Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="bg-light px-3 py-2 d-flex justify-content-between align-items-center rounded shadow-sm mb-3 text-black">
                    <div id="todays-date-peserta" class="fw-semibold"></div>
                    <div class="badge rounded-pill bg-primary fs-6 text-white">
                        <span>{{ $pesertaTerbaru->count() }}</span> peserta terbaru
                    </div>
                </div>
                <div class="peserta-list mt-3">
                    @foreach($pesertaTerbaru as $peserta)
                    <div class="peserta-item bg-white rounded shadow-sm p-3 mb-2 w-100 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-primary mb-1 fw-bold">{{ $peserta->nama }}</h6>
                            <p class="m-0 text-black">{{ $peserta->created_at->format('d M Y') }}</p>
                        </div>
                        {{-- <div class="badge bg-info text-dark">{{ $peserta->status }}</div> --}}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 col-12">
        <div class="card mb-3 card-custom background-gradient-8">
            <div class="card-header">
                <h5 class="card-title text-black">Mitra Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="bg-light px-3 py-2 d-flex justify-content-between align-items-center rounded shadow-sm mb-3 text-black">
                    <div id="todays-date-mitra" class="fw-semibold"></div>
                    <div class="badge rounded-pill bg-primary fs-6 text-white">
                        <span>{{ $mitraTerbaru->count() }}</span> mitra terbaru
                    </div>
                </div>
                <div class="peserta-list mt-3">
                    @foreach($mitraTerbaru as $mitra)
                    <div class="peserta-item bg-white rounded shadow-sm p-3 mb-2 w-100 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-primary mb-1 fw-bold">{{ $mitra->name }}</h6>
                            <p class="m-0 text-black">{{ $mitra->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="badge bg-info text-white">{{ $mitra->type }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 col-12">
        <div class="card mb-3 card-custom background-gradient-9">
            <div class="card-header">
                <h5 class="card-title text-black">Dospem Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="bg-light px-3 py-2 d-flex justify-content-between align-items-center rounded shadow-sm mb-3 text-black">
                    <div id="todays-date-dospem" class="fw-semibold"></div>
                    <div class="badge rounded-pill bg-primary fs-6 text-white">
                        <span>{{ $dospemTerbaru->count() }}</span> dospem terbaru
                    </div>
                </div>
                <div class="peserta-list mt-3">
                    @foreach($dospemTerbaru as $dospem)
                    <div class="peserta-item bg-white rounded shadow-sm p-3 mb-2 w-100 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-primary mb-1 fw-bold">{{ $dospem->name }}</h6>
                            <p class="m-0 text-black">{{ $dospem->created_at->format('d M Y') }}</p>
                        </div>
                        {{-- <div class="badge bg-info text-dark">{{ $dospem->status }}</div> --}}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/customcard.css') }}">
@endpush

@push('javascript')
<script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date();
        var options = { year: 'numeric', month: 'long', day: 'numeric' };
        var date = today.toLocaleDateString('id-ID', options);
        document.getElementById('todays-date-peserta').textContent = date;
        document.getElementById('todays-date-mitra').textContent = date;
        document.getElementById('todays-date-dospem').textContent = date;
    });
</script>
@endpush
