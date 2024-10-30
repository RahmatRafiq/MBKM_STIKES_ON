@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Isi Laporan Mingguan</h2>
    <div class="row gx-3 mb-4">
        <div class="col-xl-4 col-lg-12">
            <div class="card mb-3">
                <div class="card-header text-center">
                    <h5>Halo {{ $namaPeserta }} !</h5>
                </div>
                <div class="card-body text-center">
                    <p>Total Laporan yang sudah kamu buat: {{ $totalLaporanMingguan }}</p>
                    <p>Laporan kamu yang tervalidasi: {{ $validasiLaporanMingguan }}</p>
                    <p>Laporan kamu yang harus direvisi: {{ $revisiLaporanMingguan }}</p>
                    <p>Laporan kamu yang masih dalam review: {{ $pendingLaporanMingguan }}</p>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-12">
            <div class="row gx-3">
                @foreach ($weeks as $weekNumber => $week)
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            @if ($week['laporanMingguan'])
                            <div class="d-flex justify-content-end">
                                <span
                                    class="badge bg-{{ $week['laporanMingguan']->status == 'pending' ? 'warning' : ($week['laporanMingguan']->status == 'validasi' ? 'success' : 'danger') }}">
                                    {{ ucfirst($week['laporanMingguan']->status) }}
                                </span>
                            </div>
                            @endif
                            <h5>Minggu Ke-{{ $weekNumber }}</h5>
                            <p>{{ $week['startOfWeek']->format('d M Y') }} - {{ $week['endOfWeek']->format('d M Y') }}
                            </p>
                        </div>
                        <div class="card-body">
                            @if ($week['isCurrentOrPastWeek'])
                            @if ($week['laporanMingguan'])
                            <p>{{ $week['laporanMingguan']->isi_laporan }}</p>
                            @if ($week['laporanMingguan']->status == 'revisi')
                            <div class="text-center mt-3">
                                <button class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#modalForm_{{ $weekNumber }}">Submit Ulang</button>
                            </div>
                            @endif

                            <!-- Menampilkan dokumen yang telah diunggah -->
                            @foreach ($week['laporanMingguan']->getMedia('laporan-mingguan') as $media)
                            <div class="input-group mb-2">
                                <a href="{{ $media->getUrl() }}" target="_blank" class="btn btn-primary">Lihat Dokumen
                                    {{ $loop->iteration }}</a>
                            </div>
                            @endforeach
                            @endif

                            @if ($week['canFill'] && !$week['laporanMingguan'])
                            <div class="text-center mt-3">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalForm_{{ $weekNumber }}">Isi Laporan Mingguan</button>
                            </div>
                            @endif

                            @if ($week['hasRevisi'])
                            <div class="text-center mt-3">
                                <button class="btn btn-danger"
                                    onclick="window.location.href='{{ route('laporan.harian.create', ['week' => $weekNumber]) }}'">Ada
                                    Laporan Harian yang Revisi</button>
                            </div>
                            @endif

                            @if (!$week['canFill'])
                            <div class="text-center mt-3">
                                <button class="btn btn-warning"
                                    onclick="window.location.href='{{ route('laporan.harian.create', ['week' => $weekNumber]) }}'">Lengkapi
                                    Laporan Harian</button>
                            </div>
                            @endif

                            <div class="text-center mt-3">
                                <button class="btn btn-secondary"
                                    onclick="window.location.href='{{ route('laporan.harian.create', ['week' => $weekNumber]) }}'">Lihat
                                    Laporan Harian</button>
                            </div>
                            @else
                            <div class="text-center mt-3">
                                <p class="text-muted">Belum Dapat mengisi laporan</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                @if (!$week['laporanMingguan'] || $week['laporanMingguan']->status == 'revisi')
                <div class="modal fade" id="modalForm_{{ $weekNumber }}" tabindex="-1"
                    aria-labelledby="modalLabel_{{ $weekNumber }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel_{{ $weekNumber }}">Isi Laporan Mingguan Ke-{{
                                    $weekNumber }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('laporan.mingguan.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="minggu_ke" value="{{ $weekNumber }}">
                                    <input type="hidden" name="kehadiran" value="hadir">

                                    <!-- Isi Laporan (nullable) -->
                                    <div class="form-group mb-3">
                                        <label for="isi_laporan_{{ $weekNumber }}" class="form-label">Isi
                                            Laporan</label>
                                        <textarea name="isi_laporan" id="isi_laporan_{{ $weekNumber }}"
                                            class="form-control auto-resize">{{ $week['laporanMingguan'] ? $week['laporanMingguan']->isi_laporan : '' }}</textarea>
                                    </div>

                                    <!-- Upload Dokumen -->
                                    <div class="form-group mb-3" id="dokumen-upload-container-{{ $weekNumber }}">
                                        <label for="dokumen_{{ $weekNumber }}" class="form-label">Upload Dokumen</label>
                                        <div class="input-group mb-2">
                                            <input type="file" name="dokumen[]" id="dokumen_{{ $weekNumber }}"
                                                class="form-control" accept=".pdf,.doc,.docx">
                                        </div>
                                    </div>

                                    <!-- Tombol untuk menambah dokumen -->
                                    <button type="button" class="btn btn-outline-secondary"
                                        id="add-doc-btn-{{ $weekNumber }}">Tambah Dokumen</button>

                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let docIndex_{{ $weekNumber }} = 1; // Awal index untuk dokumen tambahan
                        const addDocButton_{{ $weekNumber }} = document.getElementById('add-doc-btn-{{ $weekNumber }}');
                        const container_{{ $weekNumber }} = document.getElementById('dokumen-upload-container-{{ $weekNumber }}');

                        addDocButton_{{ $weekNumber }}.addEventListener('click', function() {
                            if (docIndex_{{ $weekNumber }} < 3) {
                                docIndex_{{ $weekNumber }}++;

                                // Buat elemen input baru untuk dokumen tambahan
                                const newInput = document.createElement('div');
                                newInput.classList.add('input-group', 'mb-2');
                                newInput.innerHTML = `
                                    <input type="file" name="dokumen[]" class="form-control" accept=".pdf,.doc,.docx">
                                `;
                                container_{{ $weekNumber }}.appendChild(newInput); // Tambahkan ke container
                            } else {
                                alert('Maksimal 3 dokumen.');
                            }
                        });

                        // Auto-resize textarea
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

                    function deleteDocument(mediaId, laporanId) {
                        if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
                            $.ajax({
                                url: '/path/to/delete/document', // Ganti dengan URL yang sesuai
                                type: 'DELETE',
                                data: { id: mediaId },
                                success: function(response) {
                                    // Handle success
                                    alert('Dokumen berhasil dihapus.');
                                    location.reload(); // Reload halaman setelah penghapusan
                                },
                                error: function(xhr) {
                                    // Handle error
                                    alert('Terjadi kesalahan saat menghapus dokumen.');
                                }
                            });
                        }
                    }
                </script>
                @endif
                @endforeach
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