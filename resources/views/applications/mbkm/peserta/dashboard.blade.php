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
                        <i class="bi bi-briefcase-fill fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Lowongan yang Didaftarkan</h5>
                        <h3 class="m-0 text-primary">{{ $totalLowongan }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Status Lowongan</h5>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($lowonganStatus as $status => $count)
                        <li>{{ ucfirst($status) }}: {{ $count }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- Card lainnya -->
        <div class="col-xl-6 col-sm-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Laporan Harian</h5>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($laporanHarian as $tanggal => $laporan)
                        <li>{{ $tanggal }}: {{ $laporan->status }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Laporan Mingguan</h5>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($weeks as $weekNumber => $week)
                        <li>
                            Minggu {{ $weekNumber }}:
                            @if($week['laporanMingguan'])
                            {{ $week['laporanMingguan']->status }}
                            @else
                            Tidak ada laporan
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Statistik Laporan Harian</h5>
                </div>
                <div class="card-body">
                    <div id="donutChartHarian"></div>
                </div>
                <div class="grid text-center">
                    <div class="g-col-4">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <h3 class="m-0 mt-1">{{ $validasiLaporan }}</h3>
                        <p class="text-secondary m-0">Tervalidasi</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-clock-fill text-primary"></i>
                        <h3 class="m-0 mt-1 fw-bolder">{{ $pendingLaporan }}</h3>
                        <p class="text-secondary m-0">Pending</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-arrow-repeat text-danger"></i>
                        <h3 class="m-0 mt-1">{{ $revisiLaporan }}</h3>
                        <p class="text-secondary m-0">Laporan Terevisi</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Statistik Laporan Mingguan</h5>
                </div>
                <div class="card-body">
                    <div id="donutChartMingguan"></div>
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
        var optionsHarian = {
            series: [{{ $validasiLaporan }}, {{ $pendingLaporan }}, {{ $revisiLaporan }}],
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

        var donutChartHarian = new ApexCharts(document.querySelector("#donutChartHarian"), optionsHarian);
        donutChartHarian.render();

        // Data untuk Laporan Mingguan
        var optionsMingguan = {
            series: [{{ $validasiLaporan }}, {{ $pendingLaporan }}, {{ $revisiLaporan }}],
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

        var donutChartMingguan = new ApexCharts(document.querySelector("#donutChartMingguan"), optionsMingguan);
        donutChartMingguan.render();
    });
</script>
@endpush