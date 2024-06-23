{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Isi Laporan Mingguan</h2>
    @foreach ($weeks as $weekNumber => $week)
        <div class="row justify-content-center mb-4">
            <div class="col-xxl-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Minggu Ke-{{ $weekNumber }}</h5>
                        <p>{{ $week['startOfWeek']->format('d M Y') }} - {{ $week['endOfWeek']->format('d M Y') }}</p>
                        @if ($week['laporanMingguan'])
                            <span class="badge bg-{{ $week['laporanMingguan']->status == 'pending' ? 'warning' : ($week['laporanMingguan']->status == 'validasi' ? 'success' : 'danger') }}">
                                {{ ucfirst($week['laporanMingguan']->status) }}
                            </span>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($week['laporanMingguan'])
                            <p>{{ $week['laporanMingguan']->isi_laporan }}</p>
                            @if ($week['laporanMingguan']->status == 'revisi')
                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalForm_{{ $weekNumber }}">Submit Ulang</button>
                            @endif
                        @else
                            @if ($week['isComplete'])
                                <form action="{{ route('laporan.mingguan.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="minggu_ke" value="{{ $weekNumber }}">
                                    <div class="form-group mb-3">
                                        <label for="isi_laporan_{{ $weekNumber }}" class="form-label">Isi Laporan</label>
                                        <textarea name="isi_laporan" id="isi_laporan_{{ $weekNumber }}" class="form-control auto-resize" required></textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="kehadiran_{{ $weekNumber }}" class="form-label">Kehadiran</label>
                                        <select name="kehadiran" id="kehadiran_{{ $weekNumber }}" class="form-control" required>
                                            <option value="hadir">Hadir</option>
                                            <option value="tidak hadir">Tidak Hadir</option>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            @else
                                <div class="text-center">
                                    <p class="text-muted">Lengkapi laporan harian untuk minggu ini sebelum mengisi laporan mingguan.</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        @if (!$week['laporanMingguan'] || $week['laporanMingguan']->status == 'revisi')
            <div class="modal fade" id="modalForm_{{ $weekNumber }}" tabindex="-1" aria-labelledby="modalLabel_{{ $weekNumber }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel_{{ $weekNumber }}">Isi Laporan Mingguan Ke-{{ $weekNumber }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('laporan.mingguan.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="minggu_ke" value="{{ $weekNumber }}">
                                <div class="form-group mb-3">
                                    <label for="isi_laporan_{{ $weekNumber }}" class="form-label">Isi Laporan</label>
                                    <textarea name="isi_laporan" id="isi_laporan_{{ $weekNumber }}" class="form-control auto-resize" required>{{ $week['laporanMingguan'] ? $week['laporanMingguan']->isi_laporan : '' }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="kehadiran_{{ $weekNumber }}" class="form-label">Kehadiran</label>
                                    <select name="kehadiran" id="kehadiran_{{ $weekNumber }}" class="form-control" required>
                                        <option value="hadir" {{ $week['laporanMingguan'] && $week['laporanMingguan']->kehadiran == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="tidak hadir" {{ $week['laporanMingguan'] && $week['laporanMingguan']->kehadiran == 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
@endsection --}}


@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Isi Laporan Mingguan</h2>
    @foreach ($weeks as $weekNumber => $week)
        <div class="row justify-content-center mb-4">
            <div class="col-xxl-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Minggu Ke-{{ $weekNumber }}</h5>
                        <p>{{ $week['startOfWeek']->format('d M Y') }} - {{ $week['endOfWeek']->format('d M Y') }}</p>
                        @if ($week['laporanMingguan'])
                            <span class="badge bg-{{ $week['laporanMingguan']->status == 'pending' ? 'warning' : ($week['laporanMingguan']->status == 'validasi' ? 'success' : 'danger') }}">
                                {{ ucfirst($week['laporanMingguan']->status) }}
                            </span>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($week['laporanMingguan'])
                            <p>{{ $week['laporanMingguan']->isi_laporan }}</p>
                            @if ($week['laporanMingguan']->status == 'revisi')
                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalForm_{{ $weekNumber }}">Submit Ulang</button>
                            @endif
                        @else
                            @if ($week['canFill'])
                                <form action="{{ route('laporan.mingguan.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="minggu_ke" value="{{ $weekNumber }}">
                                    <div class="form-group mb-3">
                                        <label for="isi_laporan_{{ $weekNumber }}" class="form-label">Isi Laporan</label>
                                        <textarea name="isi_laporan" id="isi_laporan_{{ $weekNumber }}" class="form-control auto-resize" required></textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="kehadiran_{{ $weekNumber }}" class="form-label">Kehadiran</label>
                                        <select name="kehadiran" id="kehadiran_{{ $weekNumber }}" class="form-control" required>
                                            <option value="hadir">Hadir</option>
                                            <option value="tidak hadir">Tidak Hadir</option>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            @else
                                @if ($week['canFillDaily'])
                                    <div class="text-center">
                                        <button class="btn btn-secondary" onclick="window.location.href='{{ route('laporan.harian.create', ['week' => $weekNumber]) }}'">Lengkapi Laporan Harian</button>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <p class="text-muted">Minggu ini belum selesai.</p>
                                    </div>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        @if (!$week['laporanMingguan'] || $week['laporanMingguan']->status == 'revisi')
            <div class="modal fade" id="modalForm_{{ $weekNumber }}" tabindex="-1" aria-labelledby="modalLabel_{{ $weekNumber }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel_{{ $weekNumber }}">Isi Laporan Mingguan Ke-{{ $weekNumber }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('laporan.mingguan.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="minggu_ke" value="{{ $weekNumber }}">
                                <div class="form-group mb-3">
                                    <label for="isi_laporan_{{ $weekNumber }}" class="form-label">Isi Laporan</label>
                                    <textarea name="isi_laporan" id="isi_laporan_{{ $weekNumber }}" class="form-control auto-resize" required>{{ $week['laporanMingguan'] ? $week['laporanMingguan']->isi_laporan : '' }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="kehadiran_{{ $weekNumber }}" class="form-label">Kehadiran</label>
                                    <select name="kehadiran" id="kehadiran_{{ $weekNumber }}" class="form-control" required>
                                        <option value="hadir" {{ $week['laporanMingguan'] && $week['laporanMingguan']->kehadiran == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="tidak hadir" {{ $week['laporanMingguan'] && $week['laporanMingguan']->kehadiran == 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
