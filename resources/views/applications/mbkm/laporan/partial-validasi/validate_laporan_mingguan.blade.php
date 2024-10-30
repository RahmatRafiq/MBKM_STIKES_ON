<div class="tab-pane fade" id="mingguan" role="tabpanel" aria-labelledby="mingguan-tab">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Minggu Ke</th>
                            <th>Isi Laporan</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="laporan-mingguan-tbody">
                        @foreach ($laporanMingguan as $laporan)
                        <tr id="laporan-mingguan-{{ $laporan->id }}">
                            <td>{{ $laporan->minggu_ke }}</td>
                            <td>{{ $laporan->isi_laporan ?? 'Tidak ada isi laporan' }}</td>
                            <td>
                                @if($laporan->getMedia('laporan-mingguan')->isNotEmpty())
                                @foreach($laporan->getMedia('laporan-mingguan') as $media)
                                <a href="{{ $media->getFullUrl() }}" target="_blank" class="btn btn-primary mb-1">Lihat
                                    Dokumen {{ $loop->iteration }}</a><br>
                                @endforeach
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach ($laporanMingguan as $laporan)
<div class="modal fade" id="feedbackModalMingguan-{{ $laporan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="feedbackModalLabelMingguan-{{ $laporan->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabelMingguan-{{ $laporan->id }}">Masukkan Feedback untuk
                    Revisi</h5>
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
                    data-type="mingguan" data-action="revisi">Kirim Feedback</button>
            </div>
        </div>
    </div>
</div>
@endforeach