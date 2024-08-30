<div class="tab-pane fade show active" id="harian" role="tabpanel" aria-labelledby="harian-tab">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Isi Laporan</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="laporan-harian-tbody">
                        @foreach($laporanHarian as $laporan)
                            <tr id="laporan-harian-{{ $laporan->id }}">
                                <td>{{ $laporan->tanggal }}</td>
                                <td>{{ $laporan->isi_laporan }}</td>
                                <td>
                                    @foreach($laporan->media as $media)
                                        <a href="{{ $media->getFullUrl() }}" target="_blank">
                                            <img src="{{ $media->getFullUrl() }}" alt="Foto Laporan" class="img-thumbnail" style="max-width: 100px">
                                        </a>
                                    @endforeach
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
                                        <button class="btn btn-outline-success validate-btn mb-1" data-id="{{ $laporan->id }}" data-type="harian" data-action="validasi">
                                            Validasi
                                        </button>
                                        <button class="btn btn-outline-danger validate-btn mb-1" data-id="{{ $laporan->id }}" data-type="harian" data-action="revisi" data-toggle="modal" data-target="#feedbackModalHarian-{{ $laporan->id }}">
                                            Revisi
                                        </button>
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

@foreach ($laporanHarian as $laporan)
    <div class="modal fade" id="feedbackModalHarian-{{ $laporan->id }}" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabelHarian-{{ $laporan->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabelHarian-{{ $laporan->id }}">Masukkan Feedback untuk Revisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="feedback-{{ $laporan->id }}" class="form-control" rows="4" placeholder="Masukkan feedback..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary submit-feedback" data-id="{{ $laporan->id }}" data-type="harian" data-action="revisi">Kirim Feedback</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
