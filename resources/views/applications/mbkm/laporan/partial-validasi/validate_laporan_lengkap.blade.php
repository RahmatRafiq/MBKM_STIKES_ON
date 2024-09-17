<div class="tab-pane fade" id="lengkap" role="tabpanel" aria-labelledby="lengkap-tab">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Dosen Pembimbing</th>
                            <th>Isi Laporan</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="laporan-lengkap-tbody">
                        @foreach ($laporanLengkap as $laporan)
                        <tr id="laporan-lengkap-{{ $laporan->id }}">
                            <td>{{ $laporan->dospem->name }}</td>
                            <td>{{ $laporan->isi_laporan }}</td>
                            <td>
                                @if ($laporan->status == 'pending')
                                    <button class="btn btn-outline-success validate-btn mb-1" data-id="{{ $laporan->id }}"
                                        data-type="lengkap" data-action="validasi">Validasi</button>
                                    <button class="btn btn-outline-danger validate-btn mb-1" data-id="{{ $laporan->id }}"
                                        data-type="lengkap" data-action="revisi" data-toggle="modal"
                                        data-target="#feedbackModalLengkap-{{ $laporan->id }}">Revisi</button>
                                @endif
                            
                                @if($laporan->getFirstMediaUrl('laporan-lengkap'))
                                    <a href="{{ $laporan->getFirstMediaUrl('laporan-lengkap') }}" target="_blank" class="btn btn-primary mb-1">Lihat Dokumen</a>
                                @else
                                    <span class="text-muted">Tidak ada dokumen</span>
                                @endif
                            </td>
                            
                            <td class="status">
                                <span
                                    class="badge badge-{{ $laporan->status == 'pending' ? 'accepted_offer' : ($laporan->status == 'validasi' ? 'registered' : 'rejected') }}">
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            </td>
                            <td>{{ $laporan->feedback ?? '-' }}</td>
                            <td>
                                @if ($laporan->status == 'pending')
                                <button class="btn btn-outline-success validate-btn mb-1" data-id="{{ $laporan->id }}"
                                    data-type="lengkap" data-action="validasi">Validasi</button>
                                <button class="btn btn-outline-danger validate-btn mb-1" data-id="{{ $laporan->id }}"
                                    data-type="lengkap" data-action="revisi" data-toggle="modal"
                                    data-target="#feedbackModalLengkap-{{ $laporan->id }}">Revisi</button>
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

@foreach ($laporanLengkap as $laporan)
<div class="modal fade" id="feedbackModalLengkap-{{ $laporan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="feedbackModalLabelLengkap-{{ $laporan->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabelLengkap-{{ $laporan->id }}">Masukkan Feedback untuk Revisi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea id="feedback-{{ $laporan->id }}" class="form-control" rows="4"
                    placeholder="Masukkan feedback..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary submit-feedback" data-id="{{ $laporan->id }}"
                    data-type="lengkap" data-action="revisi">Kirim Feedback</button>
            </div>
        </div>
    </div>
</div>
@endforeach