@extends('layouts.app')

@section('content')

<div class="card-body">
    <div class="row gx-3">
        <!-- Baris pertama (4 card) -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3 card-custom background-gradient-1">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
                    <div class="mb-2">
                        <i class="bi bi-people fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Peserta</h5>
                        <h3 class="m-0 text-white">{{ $peserta }}</h3>
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
                        <i class="bi bi-person-badge fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Dosen</h5>
                        <h3 class="m-0 text-white">{{ $dosen }}</h3>
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
                        <i class="bi bi-building fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Mitra</h5>
                        <h3 class="m-0 text-white">{{ $mitra }}</h3>
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
                        <h5 class="m-0 text-white fw-normal">Lowongan</h5>
                        <h3 class="m-0 text-white">{{ $lowongan }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Baris kedua (3 card) -->
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card mb-3 card-custom background-gradient-5">
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

        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card mb-3 card-custom background-gradient-6">
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

        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card mb-3 card-custom background-gradient-7">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
                    <div class="mb-2">
                        <i class="bi bi-file-earmark-text fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Laporan Lengkap</h5>
                        <h3 class="m-0 text-white">{{ $laporanLengkap }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Baris ketiga (3 card) -->
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card mb-3 card-custom background-gradient-8">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
                    <div class="mb-2">
                        <i class="bi bi-check-circle-fill fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Validasi</h5>
                        <h3 class="m-0 text-white">{{ $validasiCount }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card mb-3 card-custom background-gradient-9">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
                    <div class="mb-2">
                        <i class="bi bi-clock-fill fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Pending</h5>
                        <h3 class="m-0 text-white">{{ $pendingCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card mb-3 card-custom background-gradient-10">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
                    <div class="mb-2">
                        <i class="bi bi-arrow-repeat fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Revisi</h5>
                        <h3 class="m-0 text-white">{{ $revisiCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gx-3">
        <div class="col-xl-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Laporan Harian Berdasarkan Status</h5>
                </div>
                <div class="card-body">
                    <div id="donutChartHarian"></div>
                </div>
                <div class="grid text-center">
                    <div class="g-col-4">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <h3 class="m-0 mt-1">{{ $validasiCount }}</h3>
                        <p class="text-secondary m-0">Tervalidasi</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-clock-fill text-primary"></i>
                        <h3 class="m-0 mt-1 fw-bolder">{{ $pendingCount }}</h3>
                        <p class="text-secondary m-0">Pending</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-arrow-repeat text-danger"></i>
                        <h3 class="m-0 mt-1">{{ $revisiCount }}</h3>
                        <p class="text-secondary m-0">Laporan Terevisi</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Laporan Mingguan Berdasarkan Status</h5>
                </div>
                <div class="card-body">
                    <div id="donutChartMingguan"></div>
                </div>
                <div class="grid text-center">
                    <div class="g-col-4">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <h3 class="m-0 mt-1">{{ $validasiCountMingguan }}</h3>
                        <p class="text-secondary m-0">Laporan Tervalidasi</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-clock-fill text-primary"></i>
                        <h3 class="m-0 mt-1 fw-bolder">{{ $pendingCountMingguan }}</h3>
                        <p class="text-secondary m-0">Laporan Pending</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-arrow-repeat text-danger"></i>
                        <h3 class="m-0 mt-1">{{ $revisiCountMingguan }}</h3>
                        <p class="text-secondary m-0">Laporan Terevisi</p>
                    </div>
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
        // Data untuk Laporan Harian
        var validasiCount = {{ $validasiCount }};
        var pendingCount = {{ $pendingCount }};
        var revisiCount = {{ $revisiCount }};
        console.log(validasiCount, pendingCount, revisiCount); // Debug data

        var optionsHarian = {
            series: [validasiCount, pendingCount, revisiCount],
            labels: ['Validasi', 'Pending', 'Revisi'],
            colors: ['#96e6a1','#ffd200', '#FF5E62', ],            chart: {
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
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'vertical',
                    gradientToColors: ['#96e6a1', '#ffd200', '#FF5E62'], // Warna akhir dari gradient-1, gradient-2, gradient-3
                    stops: [0, 100]
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

        var donutChartHarian = new ApexCharts(document.querySelector("#donutChartHarian"), optionsHarian);
        donutChartHarian.render();

        // Data untuk Laporan Mingguan
        var validasiCountMingguan = {{ $validasiCountMingguan }};
        var pendingCountMingguan = {{ $pendingCountMingguan }};
        var revisiCountMingguan = {{ $revisiCountMingguan }};
        console.log(validasiCountMingguan, pendingCountMingguan, revisiCountMingguan); // Debug data

        var optionsMingguan = {
            series: [validasiCountMingguan, pendingCountMingguan, revisiCountMingguan],
            labels: ['Validasi', 'Pending', 'Revisi'],
            colors: ['#96e6a1','#ffd200', '#FF5E62', ], // Menggunakan warna dari gradient-4, gradient-5, gradient-6
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
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'vertical',
                    gradientToColors: ['#96e6a1', '#ffd200', '#FF5E62'], // Warna akhir dari gradient-4, gradient-5, gradient-6
                    stops: [0, 100]
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

        var donutChartMingguan = new ApexCharts(document.querySelector("#donutChartMingguan"), optionsMingguan);
        donutChartMingguan.render();
    });
</script>
@endpush