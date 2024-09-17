@extends('layouts.app')

@section('content')
<div class="row gx-3">
    <h2 class="mb-4">Daftar Laporan</h2>

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
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3 mt-3">
                <span>Nama Peserta:</span>{{ $daftarPeserta->firstWhere('id', $pesertaId)->nama }}
            </h5>
            <h5 class="card-title mb-3">
                <span>Mitra Lowongan:</span>{{ $daftarPeserta->firstWhere('id',
                $pesertaId)->registrationPlacement->lowongan->mitra->name }}
            </h5>
            <h5 class="card-title mb-3">
                <span>Dosen Pembimbing:</span>{{ $daftarPeserta->firstWhere('id',
                $pesertaId)->registrationPlacement->dospem->name }}
            </h5>

            <!-- Tabs for Laporan -->
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="justify-content: center; border-bottom: none;">
                <li class="mb-2 nav-item" role="presentation">
                    <button class="btn btn-outline-primary mb-1 ml-2" id="harian-tab" data-bs-toggle="tab"
                        data-bs-target="#harian" type="button" role="tab" aria-controls="harian" aria-selected="true">
                        Laporan Harian
                    </button>
                </li>
                <li class="mb-2 nav-item" role="presentation">
                    <button class="btn btn-outline-primary mb-1 ml-2" id="mingguan-tab" data-bs-toggle="tab"
                        data-bs-target="#mingguan" type="button" role="tab" aria-controls="mingguan"
                        aria-selected="false">
                        Laporan Mingguan
                    </button>
                </li>
                <li class="mb-2 nav-item" role="presentation">
                    <button class="btn btn-outline-primary mb-1 ml-2" id="lengkap-tab" data-bs-toggle="tab"
                        data-bs-target="#lengkap" type="button" role="tab" aria-controls="lengkap"
                        aria-selected="false">
                        Laporan Lengkap
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-3" id="myTabContent">
                @include('applications.mbkm.laporan.partial-validasi.validate_laporan_harian')
                @include('applications.mbkm.laporan.partial-validasi.validate_laporan_mingguan')
                @include('applications.mbkm.laporan.partial-validasi.validate_laporan_lengkap')
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
        // Cek tab yang terakhir kali dibuka dari local storage
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('#myTab button[data-bs-target="' + activeTab + '"]').tab('show');
        }

        // Simpan tab aktif ke local storage saat tab diklik
        $('#myTab button').on('shown.bs.tab', function (e) {
            var activeTab = $(e.target).data('bs-target');
            localStorage.setItem('activeTab', activeTab);
        });

        // Mengelola validasi laporan
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

            if (action === 'revisi') {
                $('#feedbackModal' + capitalizeFirstLetter(type) + '-' + laporanId).modal('show');
                return;
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

                        if (action === 'validasi') {
                            badgeClass = 'badge-registered';
                        } else if (action === 'revisi') {
                            badgeClass = 'badge-rejected';
                        }

                        statusCell.html('<span class="badge ' + badgeClass + '">' + capitalizeFirstLetter(action) + '</span>');
                        button.closest('td').find('button').remove();

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

        $('.submit-feedback').on('click', function() {
            var button = $(this);
            var laporanId = button.data('id');
            var action = button.data('action');
            var type = button.data('type');
            var feedback = $('#feedback-' + laporanId).val();
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
                    action: action,
                    feedback: feedback
                },
                success: function(response) {
                    if (response.success) {
                        $('#feedbackModal' + capitalizeFirstLetter(type) + '-' + laporanId).modal('hide');

                        var statusCell = button.closest('tr').find('.status');
                        statusCell.html('<span class="badge badge-rejected">Revisi</span>');

                        button.closest('td').find('button').remove();

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

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    });
</script>

@endsection