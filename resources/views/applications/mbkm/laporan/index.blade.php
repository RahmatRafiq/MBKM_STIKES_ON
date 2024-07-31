@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Laporan</h2>

    <!-- Dropdown untuk memilih peserta -->
    <form method="GET" action="{{ route('laporan.index') }}">
        <div class="form-group">
            <label for="peserta_id">Pilih Peserta:</label>
            <select class="form-control" id="peserta_id" name="peserta_id" onchange="this.form.submit()">
                <option value="">-- Pilih Peserta --</option>
                @foreach ($daftarPeserta as $peserta)
                <option value="{{ $peserta->id }}" {{ $pesertaId==$peserta->id ? 'selected' : '' }}>
                    {{ $peserta->nama }}
                </option>
                @endforeach
            </select>
        </div>
    </form>

    @if ($pesertaId)
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="harian-tab" data-bs-toggle="tab" data-bs-target="#harian" type="button"
                role="tab" aria-controls="harian" aria-selected="true">Laporan Harian</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="mingguan-tab" data-bs-toggle="tab" data-bs-target="#mingguan" type="button"
                role="tab" aria-controls="mingguan" aria-selected="false">Laporan Mingguan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="lengkap-tab" data-bs-toggle="tab" data-bs-target="#lengkap" type="button"
                role="tab" aria-controls="lengkap" aria-selected="false">Laporan Lengkap</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- Laporan Harian -->
        <div class="tab-pane fade show active" id="harian" role="tabpanel" aria-labelledby="harian-tab">
            <table class="table mt-3">
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
                        <td class="status">{{ $laporan->status }}</td>
                        <td>
                            @if ($laporan->status == 'pending')
                            <button class="btn btn-success validate-btn" data-id="{{ $laporan->id }}" data-type="harian" data-action="validasi">Validasi</button>
                            <button class="btn btn-warning validate-btn" data-id="{{ $laporan->id }}" data-type="harian" data-action="revisi">Revisi</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Laporan Mingguan -->
        <div class="tab-pane fade" id="mingguan" role="tabpanel" aria-labelledby="mingguan-tab">
            <table class="table mt-3">
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
                        <td class="status">{{ $laporan->status }}</td>
                        <td>
                            @if ($laporan->status == 'pending')
                            <button class="btn btn-success validate-btn" data-id="{{ $laporan->id }}" data-type="mingguan" data-action="validasi">Validasi</button>
                            <button class="btn btn-warning validate-btn" data-id="{{ $laporan->id }}" data-type="mingguan" data-action="revisi">Revisi</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Laporan Lengkap -->
        <div class="tab-pane fade" id="lengkap" role="tabpanel" aria-labelledby="lengkap-tab">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Dosen Pembimbing</th>
                        <th>Isi Laporan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="laporan-lengkap-tbody">
                    @foreach ($laporanLengkap as $laporan)
                    <tr id="laporan-lengkap-{{ $laporan->id }}">
                        <td>{{ $laporan->peserta->nama }}</td>
                        <td>{{ $laporan->dospem->name }}</td>
                        <td>{{ $laporan->isi_laporan }}</td>
                        <td class="status">{{ $laporan->status }}</td>
                        <td>
                            @if ($laporan->status == 'pending')
                            <button class="btn btn-success validate-btn" data-id="{{ $laporan->id }}" data-type="lengkap" data-action="validasi">Validasi</button>
                            <button class="btn btn-warning validate-btn" data-id="{{ $laporan->id }}" data-type="lengkap" data-action="revisi">Revisi</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

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
                        if (action === 'validasi') {
                            statusCell.text('validasi');
                        } else if (action === 'revisi') {
                            statusCell.text('revisi');
                        }
                        button.closest('td').find('button').remove(); // Hapus semua tombol dalam cell aksi

                        // Tampilkan pesan sukses dengan Toastify
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
                    // Tampilkan pesan error dengan Toastify
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
    });
</script>
@endsection
