@extends('layouts.app')

@section('content')
<!-- App body starts -->
<div class="app-body">
    <div class="row gx-3">

        <div class="col-12 col-lg-6 col-xl-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-file-earmark-text fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Laporan Harian</h5>
                        <h3 class="m-0 text-primary">{{ $laporanHarian }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-calendar-week fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Laporan Mingguan</h5>
                        <h3 class="m-0 text-primary">{{ $laporanMingguan }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-briefcase fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Lowongan Tersedia</h5>
                        <h3 class="m-0 text-primary">{{ $lowonganTersedia }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Peserta Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="bg-light px-3 py-2 d-flex justify-content-between align-items-center">
                        <div id="todays-date" class="fw-semibold">
                        </div>
                        <div class="badge rounded-pill bg-primary fs-6">
                            <span>21</span> peserta
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="ms-3h">
                            @foreach($pesertaTerbaru as $peserta)
                            <h6 class="text-primary mb-1 fw-bold">
                                {{ $peserta->nama }}
                            </h6>
                            <h6 class="class=" m-0 text-secondary fw-normal>
                                {{ $peserta->created_at->format('d M Y') }}
                            </h6>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- App body ends -->
@endsection

@push('javascript')
asset get js
<script>
    $(document).ready(function() {
        var today = new Date();
        var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
        $('#todays-date').text(date);
    });
    
@endpush