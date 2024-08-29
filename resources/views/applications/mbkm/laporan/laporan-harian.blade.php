@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Isi Laporan Harian</h2>
    <div class="row gx-3 mb-4">
        <div class="col-xl-4 col-lg-12">
            <div class="card mb-3">
                <div class="card-header text-center">
                    <h5>Halo {{ $namaPeserta }}!</h5>
                </div>
                <div class="card-body text-center">
                    <p>Total Laporan yang sudah kamu buat: {{ $totalLaporan }}</p>
                    <p>Laporan kamu yang ter Validasi: {{ $validasiLaporan }}</p>
                    <p>Laporan kamu yang harus di Revisi: {{ $revisiLaporan }}</p>
                    <p>Laporan kamu yang masih dalam review: {{ $pendingLaporan }}</p>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-12">
            <div class="row gx-3">
                @foreach (\Carbon\CarbonPeriod::create($startOfWeek, '1 day', $endOfWeek)->filter('isWeekday') as $date)
                @php
                $formattedDate = $date->format('Y-m-d');
                $laporan = $laporanHarian->get($formattedDate);
                @endphp
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            @if ($laporan)
                            <div class="d-flex justify-content-end">
                                <span
                                    class="badge bg-{{ $laporan->status == 'pending' ? 'warning' : ($laporan->status == 'validasi' ? 'success' : 'danger') }}">
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            </div>
                            @endif
                            <h5>Hari {{ $date->format('l') }}</h5>
                            <p>{{ $formattedDate }}</p>
                        </div>
                        <div class="card-body">
                            @if ($laporan)
                            <p>{{ $laporan->isi_laporan }}</p>
                            @if ($laporan->status == 'revisi')
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#modalForm_{{ $date->format('d') }}">Submit Ulang</button>
                            </div>
                            @endif
                            @else
                            @if ($date->lte($currentDate))
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalForm_{{ $date->format('d') }}">Isi Laporan</button>
                            </div>
                            @else
                            <div class="text-center">
                                <p class="text-muted">Kamu Belum Bisa Mengisi Laporannya</p>
                            </div>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal untuk Isi Laporan -->
                <div class="modal fade" id="modalForm_{{ $date->format('d') }}" tabindex="-1"
                    aria-labelledby="modalLabel_{{ $date->format('d') }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel_{{ $date->format('d') }}">Isi Laporan Hari {{
                                    $date->format('l') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('laporan.harian.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="tanggal_{{ $date->format('d') }}" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal_{{ $date->format('d') }}"
                                            name="tanggal" value="{{ $formattedDate }}" required readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kehadiran_{{ $date->format('d') }}"
                                            class="form-label">Kehadiran</label>
                                        <select class="form-select kehadiran" id="kehadiran_{{ $date->format('d') }}"
                                            name="kehadiran" required>
                                            <option value="hadir">Hadir</option>
                                            <option value="libur nasional">Libur Nasional</option>
                                            <option value="sakit">Sakit</option>
                                            <option value="cuti">Cuti/Keperluan pribadi</option>
                                            <option value="tidak ada operasional">Tidak ada operasional</option>
                                            <option value="bencana">Bencana alam/Force majeure</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 isi-laporan-container">
                                        <label for="isi_laporan_{{ $date->format('d') }}" class="form-label">Isi
                                            Laporan</label>
                                        <textarea class="form-control auto-resize"
                                            id="isi_laporan_{{ $date->format('d') }}" name="isi_laporan"
                                            required>{{ $laporan ? $laporan->isi_laporan : '' }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="laporan_foto_{{ $date->format('d') }}" class="form-label">Upload
                                            Foto</label>
                                        <div class="dropzone my-dropzone"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('head')
@vite(['resources/js/dropzoner.js'])
<script src="{{ asset('assets/vendor/toastify/toastify.js') }}"></script>
@endpush

@push('javascript')
<script type="module">
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.my-dropzone').forEach(function(dropzoneElement) {
            const csrf = "{{ csrf_token() }}";

            const dropzoneInstance = Dropzoner(
                dropzoneElement,
                'dokumen[]', // Mengirimkan file sebagai array
                {
                    urlStore: "{{ route('laporan.harian.uploadDokumen') }}",
                    csrf,
                    acceptedFiles: 'image/*',
                    maxFiles: 5,
                    kind: 'image',
                    autoProcessQueue: true // Membuat upload otomatis
                }
            );

            dropzoneInstance.on("sending", function(file, xhr, formData) {
                const dateInput = dropzoneElement.closest('.modal-body').querySelector('input[name="tanggal"]');
                formData.append('dokumen[]', file); // Pastikan file ditambahkan ke FormData
                formData.append('tanggal', dateInput.value);

                console.log('Form data yang dikirim:', formData); // Debug log untuk melihat data yang dikirim
            });

            dropzoneInstance.on("success", function(file, response) {
                console.log("File uploaded successfully: ", response);
            });

            dropzoneInstance.on("error", function(file, errorMessage, xhr) {
                console.error("Error saat upload: ", errorMessage);
            });

            dropzoneInstance.on("queuecomplete", function() {
                Toastify({
                    text: "Dokumen berhasil diupload",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "green",
                }).showToast();
            });
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

        // Mengatur perubahan pilihan Kehadiran
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
@endpush