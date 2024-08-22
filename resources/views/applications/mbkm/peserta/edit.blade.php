<div class="card">
    <div class="card-header">Edit Profil Peserta</div>
    <div class="card-body">
        <form method="POST" action="{{ route('peserta.update', $peserta->id) }}">
            @csrf
            @method('PUT')
            <div class="row gx-3">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="m-0">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $peserta->nama) }}"
                                    class="form-control @error('nama') is-invalid @enderror" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="m-0">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" name="nim" id="nim" value="{{ old('nim', $peserta->nim) }}"
                                    class="form-control @error('nim') is-invalid @enderror" required>
                                @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="m-0">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <input type="text" name="jurusan" id="jurusan"
                                    value="{{ old('jurusan', $peserta->jurusan) }}"
                                    class="form-control @error('jurusan') is-invalid @enderror" required>
                                @error('jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="m-0">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $peserta->tanggal_lahir ? $peserta->tanggal_lahir->format('Y-m-d') : '') }}"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror" required>
                                @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="m-0">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki" {{ old('jenis_kelamin', $peserta->jenis_kelamin) ==
                                        'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $peserta->jenis_kelamin) ==
                                        'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="m-0">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" name="alamat" id="alamat"
                                    value="{{ old('alamat', $peserta->alamat) }}"
                                    class="form-control @error('alamat') is-invalid @enderror" required>
                                @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="m-0">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" name="telepon" id="telepon"
                                    value="{{ old('telepon', $peserta->telepon) }}"
                                    class="form-control @error('telepon') is-invalid @enderror" required>
                                @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <!-- Form untuk Surat Rekomendasi -->
        <form method="POST"
            action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'surat_rekomendasi']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="surat_rekomendasi" class="form-label">Surat Rekomendasi</label>
                <div class="dropzone" id="suratRekomendasiDropzone"></div>
            </div>
        </form>

        <!-- Form untuk Transkrip Nilai -->
        <form method="POST" action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'transkrip_nilai']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="transkrip_nilai" class="form-label">Transkrip Nilai</label>
                <div class="dropzone" id="transkripNilaiDropzone"></div>
            </div>
        </form>

        <!-- Form untuk CV -->
        <form method="POST" action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'cv']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="cv" class="form-label">Curriculum Vitae (CV)</label>
                <div class="dropzone" id="cvDropzone"></div>
            </div>
        </form>

        <!-- Form untuk Surat Pakta Integritas -->
        <form method="POST" action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'pakta_integritas']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="pakta_integritas" class="form-label">Surat Pakta Integritas</label>
                <div class="dropzone" id="paktaIntegritasDropzone"></div>
            </div>
        </form>

        <!-- Form untuk Surat Izin Orangtua -->
        <form method="POST" action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'izin_orangtua']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="izin_orangtua" class="form-label">Surat Izin Orangtua</label>
                <div class="dropzone" id="izinOrangtuaDropzone"></div>
            </div>
        </form>

        <!-- Form untuk Surat Keterangan Sehat -->
        <form method="POST"
            action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'surat_keterangan_sehat']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="surat_keterangan_sehat" class="form-label">Surat Keterangan Sehat</label>
                <div class="dropzone" id="suratKeteranganSehatDropzone"></div>
            </div>
        </form>
    </div>
</div>

@push('head')
@vite(['resources/js/dropzoner.js'])
@endpush

@push('javascript')
<script type="module">
    const csrf = "{!! csrf_token() !!}";

    const files = {
        surat_rekomendasi: {!! json_encode($peserta->getMedia('surat_rekomendasi')->map(function($file) {
            return [
                'id' => $file->id,
                'name' => $file->file_name,
                'size' => $file->size,
                'url' => $file->getUrl()
            ];
        })) !!},

        transkrip_nilai: {!! json_encode($peserta->getMedia('transkrip_nilai')->map(function($file) {
            return [
                'id' => $file->id,
                'name' => $file->file_name,
                'size' => $file->size,
                'url' => $file->getUrl()
            ];
        })) !!},

        cv: {!! json_encode($peserta->getMedia('cv')->map(function($file) {
            return [
                'id' => $file->id,
                'name' => $file->file_name,
                'size' => $file->size,
                'url' => $file->getUrl()
            ];
        })) !!},

        pakta_integritas: {!! json_encode($peserta->getMedia('pakta_integritas')->map(function($file) {
            return [
                'id' => $file->id,
                'name' => $file->file_name,
                'size' => $file->size,
                'url' => $file->getUrl()
            ];
        })) !!},

        izin_orangtua: {!! json_encode($peserta->getMedia('izin_orangtua')->map(function($file) {
            return [
                'id' => $file->id,
                'name' => $file->file_name,
                'size' => $file->size,
                'url' => $file->getUrl()
            ];
        })) !!},

        surat_keterangan_sehat: {!! json_encode($peserta->getMedia('surat_keterangan_sehat')->map(function($file) {
            return [
                'id' => $file->id,
                'name' => $file->file_name,
                'size' => $file->size,
                'url' => $file->getUrl()
            ];
        })) !!}
    };

    Dropzoner('#suratRekomendasiDropzone', 'file', {
        urlStore: "{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'surat_rekomendasi']) }}",
        urlDestroy: "{{ route('peserta.destroyFile', ['id' => $peserta->id, 'type' => 'surat_rekomendasi']) }}",
        csrf: csrf,
        acceptedFiles: 'application/pdf,.doc,.docx',
        maxFiles: 1,
        files: files.surat_rekomendasi,
        kind: 'file'
    });

    Dropzoner('#transkripNilaiDropzone', 'file', {
        urlStore: "{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'transkrip_nilai']) }}",
        urlDestroy: "{{ route('peserta.destroyFile', ['id' => $peserta->id, 'type' => 'transkrip_nilai']) }}",
        csrf: csrf,
        acceptedFiles: 'application/pdf,.doc,.docx',
        maxFiles: 1,
        files: files.transkrip_nilai,
        kind: 'file'
    });

    Dropzoner('#cvDropzone', 'file', {
        urlStore: "{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'cv']) }}",
        urlDestroy: "{{ route('peserta.destroyFile', ['id' => $peserta->id, 'type' => 'cv']) }}",
        csrf: csrf,
        acceptedFiles: 'application/pdf,.doc,.docx',
        maxFiles: 1,
        files: files.cv,
        kind: 'file'
    });

    Dropzoner('#paktaIntegritasDropzone', 'file', {
        urlStore: "{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'pakta_integritas']) }}",
        urlDestroy: "{{ route('peserta.destroyFile', ['id' => $peserta->id, 'type' => 'pakta_integritas']) }}",
        csrf: csrf,
        acceptedFiles: 'application/pdf,.doc,.docx',
        maxFiles: 1,
        files: files.pakta_integritas,
        kind: 'file'
    });

    Dropzoner('#izinOrangtuaDropzone', 'file', {
        urlStore: "{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'izin_orangtua']) }}",
        urlDestroy: "{{ route('peserta.destroyFile', ['id' => $peserta->id, 'type' => 'izin_orangtua']) }}",
        csrf: csrf,
        acceptedFiles: 'application/pdf,.doc,.docx',
        maxFiles: 1,
        files: files.izin_orangtua,
        kind: 'file'
    });

    Dropzoner('#suratKeteranganSehatDropzone', 'file', {
        urlStore: "{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'surat_keterangan_sehat']) }}",
        urlDestroy: "{{ route('peserta.destroyFile', ['id' => $peserta->id, 'type' => 'surat_keterangan_sehat']) }}",
        csrf: csrf,
        acceptedFiles: 'application/pdf,.doc,.docx',
        maxFiles: 1,
        files: files.surat_keterangan_sehat,
        kind: 'file'
    });
</script>
@endpush



