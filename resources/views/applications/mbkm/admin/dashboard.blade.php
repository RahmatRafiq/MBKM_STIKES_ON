@extends('layouts.app')

@section('content')
<style>
    .card-custom {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        color: white;
    }

    .circle-shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
    }

    .shape-1 {
        width: 150px;
        height: 150px;
        top: -50px;
        right: -50px;
    }

    .shape-2 {
        width: 120px;
        height: 120px;
        bottom: -25px;
        left: -25px;
    }

    .shape-3 {
        width: 75px;
        height: 75px;
        top: 50px;
        left: 70px;
    }

    .background-gradient-1 {
        background: linear-gradient(135deg, #FF5F6D, #FFC371);
    }

    .background-gradient-2 {
        background: linear-gradient(135deg, #36D1DC, #5B86E5);
    }

    .background-gradient-3 {
        background: linear-gradient(135deg, #6A82FB, #FC5C7D);
    }

    .background-gradient-4 {
        background: linear-gradient(135deg, #FF9966, #FF5E62);
    }

    .background-gradient-5 {
        background: linear-gradient(135deg, #00C9FF, #92FE9D);
    }

    .background-gradient-6 {
        background: linear-gradient(135deg, #f7971e, #ffd200);
    }

    .background-gradient-7 {
        background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
    }

    .background-gradient-8 {
        background: linear-gradient(135deg, #d4fc79, #96e6a1);
    }

    .background-gradient-9 {
        background: linear-gradient(135deg, #ff9a9e, #fecfef);
    }

    .background-gradient-10 {
        background: linear-gradient(135deg, #fbc2eb, #a6c1ee);
    }
</style>

<!-- App body starts -->
<div class="app-body">
    <!-- Row start -->
    <div class="row gx-3">
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
        <div class="col-xl-3 col-sm-6 col-12">
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
        <div class="col-xl-3 col-sm-6 col-12">
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
        <div class="col-xl-3 col-sm-6 col-12">
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
        <div class="col-xl-3 col-sm-6 col-12">
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
                        <h3 class="m-0 text-white">{{ $validasiCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
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
        <div class="col-xl-3 col-sm-6 col-12">
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
    <!-- Row end -->
</div>
<!-- App body ends -->
@endsection

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
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'vertical',
                    gradientToColors: ['#00b09b', '#f7b733', '#ee0979'],
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
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'vertical',
                    gradientToColors: ['#00b09b', '#f7b733', '#ee0979'],
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