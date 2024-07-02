@extends('layouts.app')

@section('content')
<!-- App body starts -->
<div class="app-body">
    <!-- Row start -->
    <div class="row gx-3">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-people fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Peserta</h5>
                        <h3 class="m-0 text-primary">{{ $peserta }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-person-badge fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Dosen</h5>
                        <h3 class="m-0 text-primary">{{ $dosen }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-building fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Mitra</h5>
                        <h3 class="m-0 text-primary">{{ $mitra }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-briefcase fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Lowongan</h5>
                        <h3 class="m-0 text-primary">{{ $lowongan }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
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
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
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
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-file-earmark-text fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Laporan Lengkap</h5>
                        <h3 class="m-0 text-primary">{{ $laporanLengkap }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Laporan Harian Berdasarkan Status</h5>
                </div>
                <div class="card-body">
                    <div id="donutChart"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end -->
</div>
<!-- App body ends -->
@endsection



@push('javascript')
<script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var validasiCount = {{ $validasiCount }};
        var pendingCount = {{ $pendingCount }};
        var revisiCount = {{ $revisiCount }};
        console.log(validasiCount, pendingCount, revisiCount); // Debug data

        var options = {
            series: [validasiCount, pendingCount, revisiCount],
            labels: ['Validasi', 'Pending', 'Revisi'],
            colors: ['#28a745', '#ffc107', '#dc3545'],
            chart: {
                type: 'donut',
                height: 350,
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%'
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var donutChart = new ApexCharts(document.querySelector("#donutChart"), options);

        donutChart.render();
    });
</script>
@endpush

