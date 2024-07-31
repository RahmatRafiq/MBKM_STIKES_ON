@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Laporan</h2>

    <!-- Dropdown untuk memilih peserta -->
    <form method="GET" action="{{ route('laporan.index') }}">
        <div class="form-group">
            <label for="peserta_id">Pilih Peserta:</label>
            <select class="form-control" id="peserta_id" name="peserta_id" onchange="this.form.submit()">
                <option value="">-- Pilih Peserta --</option>
                @foreach ($daftarPeserta as $peserta)
                <option value="{{ $peserta->id }}" {{ $pesertaId == $peserta->id ? 'selected' : '' }}>
                    {{ $peserta->nama }}
                </option>
                @endforeach
            </select>
        </div>
    </form>

    @if ($pesertaId)
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3 mt-3">
                <strong>Nama Peserta:</strong> <span>{{ $daftarPeserta->firstWhere('id', $pesertaId)->nama }}</span>
            </h5>
            <h5 class="card-title mb-3">
                <strong>Mitra Lowongan:</strong> <span>{{ $daftarPeserta->firstWhere('id', $pesertaId)->registrationPlacement->lowongan->mitra->name }}</span>
            </h5>
            <h5 class="card-title mb-3">
                <strong>Dosen Pembimbing:</strong> <span>{{ $daftarPeserta->firstWhere('id', $pesertaId)->registrationPlacement->dospem->name }}</span>
            </h5>

            <!-- Tabs for Laporan -->
            <ul class="nav nav-tabs sticky-top bg-white" id="myTab" role="tablist" style="justify-content: center; border-bottom: none;">
                <li class="mb-2 nav-item" role="presentation">
                    <button class="nav-link active" id="harian-tab" data-bs-toggle="tab" data-bs-target="#harian" type="button"
                        role="tab" aria-controls="harian" aria-selected="true" style="border: 1px solid #007bff; border-radius: 4px 4px 0 0; margin-right: 4px;">
                        Laporan Harian
                    </button>
                </li>
                <li class="mb-2 nav-item" role="presentation">
                    <button class="nav-link" id="mingguan-tab" data-bs-toggle="tab" data-bs-target="#mingguan" type="button"
                        role="tab" aria-controls="mingguan" aria-selected="false" style="border: 1px solid #007bff; border-radius: 4px 4px 0 0; margin-right: 4px;">
                        Laporan Mingguan
                    </button>
                </li>
                <li class="mb-2 nav-item" role="presentation">
                    <button class="nav-link" id="lengkap-tab" data-bs-toggle="tab" data-bs-target="#lengkap" type="button"
                        role="tab" aria-controls="lengkap" aria-selected="false" style="border: 1px solid #007bff; border-radius: 4px 4px 0 0;">
                        Laporan Lengkap
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-3" id="myTabContent">
                <!-- Laporan Harian -->
                <div class="tab-pane fade show active" id="harian" role="tabpanel" aria-labelledby="harian-tab">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Isi Laporan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="laporan-harian-tbody">
                                        @foreach ($laporanHarian as $laporan)
                                        <tr id="laporan-harian-{{ $laporan->id }}">
                                            <td>{{ $laporan->tanggal }}</td>
                                            <td>{{ $laporan->isi_laporan }}</td>
                                            <td class="status">
                                                <span class="badge badge-{{ $laporan->status == 'pending' ? 'accepted_offer' : ($laporan->status == 'validasi' ? 'registered' : 'rejected') }}">
                                                    {{ ucfirst($laporan->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($laporan->status == 'pending')
                                                <button class="btn btn-outline-success validate-btn mb-1" data-id="{{ $laporan->id }}" data-type="harian" data-action="validasi">Validasi</button>
                                                <button class="btn btn-outline-danger validate-btn mb-1" data-id="{{ $laporan->id }}" data-type="harian" data-action="revisi">Revisi</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laporan Mingguan -->
                <div class="tab-pane fade" id="mingguan" role="tabpanel" aria-labelledby="mingguan-tab">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Minggu Ke</th>
                                            <th>Isi Laporan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="laporan-mingguan-tbody">
                                        @foreach ($laporanMingguan as $laporan)
                                        <tr id="laporan-mingguan-{{ $laporan->id }}">
                                            <td>{{ $laporan->minggu_ke }}</td>
                                            <td>{{ $laporan->isi_laporan }}</td>
                                            <td class="status">
                                                <span class="badge badge-{{ $laporan->status == 'pending' ? 'accepted_offer' : ($laporan->status == 'validasi' ? 'registered' : 'rejected') }}">
                                                    {{ ucfirst($laporan->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($laporan->status == 'pending')
                                                <button class="btn btn-outline-success validate-btn mb-1" data-id="{{ $laporan->id }}" data-type="harian" data-action="validasi">Validasi</button>
                                                <button class="btn btn-outline-danger validate-btn mb-1" data-id="{{ $laporan->id }}" data-type="harian" data-action="revisi">Revisi</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laporan Lengkap -->
                <div class="tab-pane fade" id="lengkap" role="tabpanel" aria-labelledby="lengkap-tab">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Dosen Pembimbing</th>
                                            <th>Isi Laporan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="laporan-lengkap-tbody">
                                        @foreach ($laporanLengkap as $laporan)
                                        <tr id="laporan-lengkap-{{ $laporan->id }}">
                                            <td>{{ $laporan->dospem->name }}</td>
                                            <td>{{ $laporan->isi_laporan }}</td>
                                            <td class="status">
                                                <span class="badge badge-{{ $laporan->status == 'pending' ? 'accepted_offer' : ($laporan->status == 'validasi' ? 'registered' : 'rejected') }}">
                                                    {{ ucfirst($laporan->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($laporan->status == 'pending')
                                                <button class="btn btn-outline-success validate-btn mb-1" data-id="{{ $laporan->id }}" data-type="harian" data-action="validasi">Validasi</button>
                                                <button class="btn btn-outline-danger validate-btn mb-1" data-id="{{ $laporan->id }}" data-type="harian" data-action="revisi">Revisi</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<link rel="stylesheet" href="{{ asset('assets/css/badges.css') }}">

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/toastify/toastify.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.validate-btn').on('click', function() {
            var button = $(this);
            var laporanId = button.data('id');
            var action = button.data('action');
            var type = button.data('type');
            var url = '';

            if (type === 'harian') {
                url = '{{ url("laporan-harian/validate") }}/' + laporanId;
            } else if (type === 'mingguan') {
                url = '{{ url("laporan-mingguan/validate") }}/' + laporanId;
            } else if (type === 'lengkap') {
                url = '{{ url("laporan-lengkap/validate") }}/' + laporanId;
            }

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}',
                    action: action
                },
                success: function(response) {
                    if (response.success) {
                        var statusCell = button.closest('tr').find('.status');
                        var badgeClass = '';

                        // Set badge class based on the action
                        if (action === 'validasi') {
                            badgeClass = 'badge-registered'; // Green
                        } else if (action === 'revisi') {
                            badgeClass = 'badge-rejected'; // Red
                        }

                        // Update status badge with the appropriate class
                        statusCell.html('<span class="badge ' + badgeClass + '">' + ucfirst(action) + '</span>');

                        // Remove all buttons from the action cell
                        button.closest('td').find('button').remove();

                        // Display success message with Toastify
                        Toastify({
                            text: response.success,
                            duration: 5000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#2dce89",
                            stopOnFocus: true,
                        }).showToast();
                    }
                },
                error: function(xhr) {
                    // Display error message with Toastify
                    Toastify({
                        text: 'Terjadi kesalahan saat memperbarui status.',
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#f5365c",
                        stopOnFocus: true,
                    }).showToast();
                }
            });
        });

        function ucfirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    });
</script>

@endsection
