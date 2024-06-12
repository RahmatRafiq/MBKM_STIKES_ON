{{-- @extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header">
            <h5 class="card-title">Isi Laporan Harian</h5>
        </div>
        <div class="card-body">
            @for ($i = 0; $i < 5; $i++)
            <form action="{{ route('laporan.harian.store') }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-3">
                    <h6>Hari {{ \Carbon\Carbon::now()->startOfWeek()->addDays($i)->format('l') }}</h6>
                </div>
                <div class="mb-3">
                    <label for="tanggal_{{ $i }}" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal_{{ $i }}" name="tanggal" required>
                </div>
                <div class="mb-3">
                    <label for="kehadiran_{{ $i }}" class="form-label">Kehadiran</label>
                    <select class="form-select kehadiran" id="kehadiran_{{ $i }}" name="kehadiran" required>
                        <option value="hadir">Hadir</option>
                        <option value="libur nasional">Libur Nasional</option>
                        <option value="sakit">Sakit</option>
                        <option value="cuti">Cuti/Keperluan pribadi</option>
                        <option value="tidak ada operasional">Tidak ada operasional</option>
                        <option value="bencana">Bencana alam/Force majeure</option>
                    </select>
                </div>
                <div class="mb-3 isi-laporan-container">
                    <label for="isi_laporan_{{ $i }}" class="form-label">Isi Laporan</label>
                    <textarea class="form-control" id="isi_laporan_{{ $i }}" name="isi_laporan" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
            <hr>
            @endfor
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.kehadiran').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                const isiLaporanContainer = this.closest('form').querySelector('.isi-laporan-container');
                if (['libur nasional', 'sakit', 'cuti', 'tidak ada operasional', 'bencana'].includes(this.value)) {
                    isiLaporanContainer.querySelector('label').innerText = 'Keterangan';
                    isiLaporanContainer.querySelector('textarea').setAttribute('placeholder', 'Isi keterangan alasan tidak hadir');
                } else {
                    isiLaporanContainer.querySelector('label').innerText = 'Isi Laporan';
                    isiLaporanContainer.querySelector('textarea').removeAttribute('placeholder');
                }
            });
        });
    });
</script>

@endsection --}}
{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @for ($i = 0; $i < 5; $i++)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5>Hari {{ \Carbon\Carbon::now()->startOfWeek()->addDays($i)->format('l') }}</h5>
                    <p>{{ \Carbon\Carbon::now()->startOfWeek()->addDays($i)->format('Y-m-d') }}</p>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm_{{ $i }}">Isi Laporan</button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalForm_{{ $i }}" tabindex="-1" aria-labelledby="modalLabel_{{ $i }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel_{{ $i }}">Isi Laporan Hari {{ \Carbon\Carbon::now()->startOfWeek()->addDays($i)->format('l') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('laporan.harian.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="tanggal_{{ $i }}" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal_{{ $i }}" name="tanggal" value="{{ \Carbon\Carbon::now()->startOfWeek()->addDays($i)->format('Y-m-d') }}" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="kehadiran_{{ $i }}" class="form-label">Kehadiran</label>
                                <select class="form-select kehadiran" id="kehadiran_{{ $i }}" name="kehadiran" required>
                                    <option value="hadir">Hadir</option>
                                    <option value="libur nasional">Libur Nasional</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="cuti">Cuti/Keperluan pribadi</option>
                                    <option value="tidak ada operasional">Tidak ada operasional</option>
                                    <option value="bencana">Bencana alam/Force majeure</option>
                                </select>
                            </div>
                            <div class="mb-3 isi-laporan-container">
                                <label for="isi_laporan_{{ $i }}" class="form-label">Isi Laporan</label>
                                <textarea class="form-control" id="isi_laporan_{{ $i }}" name="isi_laporan" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.kehadiran').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                const isiLaporanContainer = this.closest('.modal-body').querySelector('.isi-laporan-container');
                if (['libur nasional', 'sakit', 'cuti', 'tidak ada operasional', 'bencana'].includes(this.value)) {
                    isiLaporanContainer.querySelector('label').innerText = 'Keterangan';
                    isiLaporanContainer.querySelector('textarea').setAttribute('placeholder', 'Isi keterangan alasan tidak hadir');
                } else {
                    isiLaporanContainer.querySelector('label').innerText = 'Isi Laporan';
                    isiLaporanContainer.querySelector('textarea').removeAttribute('placeholder');
                }
            });
        });
    });
</script>
@endsection --}}


@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row gx-3">
        @for ($i = 0; $i < 5; $i++)
        <div class="col-xxl-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Hari {{ \Carbon\Carbon::now()->startOfWeek()->addDays($i)->format('l') }}</h5>
                    <p>{{ \Carbon\Carbon::now()->startOfWeek()->addDays($i)->format('Y-m-d') }}</p>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm_{{ $i }}">Isi Laporan</button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalForm_{{ $i }}" tabindex="-1" aria-labelledby="modalLabel_{{ $i }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel_{{ $i }}">Isi Laporan Hari {{ \Carbon\Carbon::now()->startOfWeek()->addDays($i)->format('l') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('laporan.harian.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="tanggal_{{ $i }}" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal_{{ $i }}" name="tanggal" value="{{ \Carbon\Carbon::now()->startOfWeek()->addDays($i)->format('Y-m-d') }}" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="kehadiran_{{ $i }}" class="form-label">Kehadiran</label>
                                <select class="form-select kehadiran" id="kehadiran_{{ $i }}" name="kehadiran" required>
                                    <option value="hadir">Hadir</option>
                                    <option value="libur nasional">Libur Nasional</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="cuti">Cuti/Keperluan pribadi</option>
                                    <option value="tidak ada operasional">Tidak ada operasional</option>
                                    <option value="bencana">Bencana alam/Force majeure</option>
                                </select>
                            </div>
                            <div class="mb-3 isi-laporan-container">
                                <label for="isi_laporan_{{ $i }}" class="form-label">Isi Laporan</label>
                                <textarea class="form-control auto-resize" id="isi_laporan_{{ $i }}" name="isi_laporan" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.kehadiran').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                const isiLaporanContainer = this.closest('.modal-body').querySelector('.isi-laporan-container');
                if (['libur nasional', 'sakit', 'cuti', 'tidak ada operasional', 'bencana'].includes(this.value)) {
                    isiLaporanContainer.querySelector('label').innerText = 'Keterangan';
                    isiLaporanContainer.querySelector('textarea').setAttribute('placeholder', 'Isi keterangan alasan tidak hadir');
                } else {
                    isiLaporanContainer.querySelector('label').innerText = 'Isi Laporan';
                    isiLaporanContainer.querySelector('textarea').removeAttribute('placeholder');
                }
            });
        });

        document.querySelectorAll('.auto-resize').forEach(function(textarea) {
            textarea.style.overflow = 'hidden';
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';

            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });
    });
</script>
@endsection
