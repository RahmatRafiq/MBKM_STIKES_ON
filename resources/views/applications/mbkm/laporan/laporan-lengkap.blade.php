@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Isi Laporan Lengkap</h2>
    <div class="card">
        <div class="card-header">
            @if ($laporanLengkap)
            <div class="d-flex justify-content-end">
                <span
                    class="badge bg-{{ $laporanLengkap->status == 'pending' ? 'warning' : ($laporanLengkap->status == 'validasi' ? 'success' : 'danger') }}">
                    {{ ucfirst($laporanLengkap->status) }}
                </span>
            </div>
            @endif
            <h5 class="text-center">Laporan Lengkap</h5>
        </div>
        <div class="card-body text-center">
            @if ($laporanLengkap)
            <!-- Tampilkan isi laporan jika sudah ada -->
            <p class="my-3">{{ $laporanLengkap->isi_laporan }}</p>

            <!-- Tombol "Lihat Dokumen" -->
            @if ($laporanLengkap->getFirstMediaUrl('laporan-lengkap'))
            <a href="{{ $laporanLengkap->getFirstMediaUrl('laporan-lengkap') }}" target="_blank"
                class="btn btn-outline-primary mb-3">
                Lihat Dokumen
            </a>
            @endif

            <!-- Tombol submit ulang jika status laporan adalah 'revisi' -->
            @if ($laporanLengkap->status == 'revisi')
            <div class="text-center mt-3">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalFormLaporanLengkap">Submit
                    Ulang</button>
            </div>
            @endif

            @else
            <!-- Jika belum ada laporan, tampilkan tombol untuk mengisi laporan -->
            <div class="text-center mt-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormLaporanLengkap">Isi
                    Laporan Lengkap</button>
            </div>
            @endif

            <!-- Tombol untuk mengisi kuisioner jika laporan lengkap telah tervalidasi -->
            @if ($laporanLengkap && $laporanLengkap->status == 'validasi')
            <div class="text-center mt-3">
                <a href="{{ route('questionnaire.create', ['peserta_id' => $laporanLengkap->peserta_id]) }}"
                    class="btn btn-success">Isi Kuisioner</a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalFormLaporanLengkap" tabindex="-1" aria-labelledby="modalLabelLaporanLengkap"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelLaporanLengkap">Isi Laporan Lengkap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('laporan.lengkap.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Hidden field for the current date -->
                    <input type="hidden" name="tanggal" value="{{ now()->toDateString() }}">

                    <div class="form-group mb-3">
                        <label for="isi_laporan_lengkap" class="form-label">Isi Laporan</label>
                        <textarea name="isi_laporan" id="isi_laporan_lengkap" class="form-control auto-resize"
                            required>{{ old('isi_laporan', $laporanLengkap ? $laporanLengkap->isi_laporan : '') }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="dokumen" class="form-label">Unggah Dokumen</label>
                        <input type="file" name="dokumen" id="dokumen" class="form-control" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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