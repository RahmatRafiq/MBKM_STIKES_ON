<div class="card">
    <div class="card-header">Edit Profil Peserta</div>
    <div class="card-body">
        <!-- Form untuk mengupdate data peserta -->
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
        <!-- Form untuk Surat Rekomendasi -->
        <form method="POST"
            action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'surat_rekomendasi']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="surat_rekomendasi" class="form-label">Surat Rekomendasi</label>
                <input type="file" name="file" class="form-control" required>

                @if($peserta->getFirstMediaUrl('surat_rekomendasi'))
                <a href="{{ $peserta->getFirstMediaUrl('surat_rekomendasi') }}" target="_blank"
                    class="btn btn-secondary mt-2">Lihat Surat Rekomendasi</a>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <!-- Form untuk Transkrip Nilai -->
        <form method="POST" action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'transkrip_nilai']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="transkrip_nilai" class="form-label">Transkrip Nilai</label>
                <input type="file" name="file" class="form-control" required>

                @if($peserta->getFirstMediaUrl('transkrip_nilai'))
                <a href="{{ $peserta->getFirstMediaUrl('transkrip_nilai') }}" target="_blank"
                    class="btn btn-secondary mt-2">Lihat Transkrip Nilai</a>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <!-- Form untuk CV -->
        <form method="POST" action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'cv']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for "cv" class="form-label">Curriculum Vitae (CV)</label>
                <input type="file" name="file" class="form-control" required>

                @if($peserta->getFirstMediaUrl('cv'))
                <a href="{{ $peserta->getFirstMediaUrl('cv') }}" target="_blank" class="btn btn-secondary mt-2">Lihat
                    CV</a>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <!-- Form untuk Surat Pakta Integritas -->
        <form method="POST" action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'pakta_integritas']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="pakta_integritas" class="form-label">Surat Pakta Integritas</label>
                <input type="file" name="file" class="form-control" required>

                @if($peserta->getFirstMediaUrl('pakta_integritas'))
                <a href="{{ $peserta->getFirstMediaUrl('pakta_integritas') }}" target="_blank"
                    class="btn btn-secondary mt-2">Lihat Surat Pakta Integritas</a>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <!-- Form untuk Surat Izin Orangtua -->
        <form method="POST" action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'izin_orangtua']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="izin_orangtua" class="form-label">Surat Izin Orangtua</label>
                <input type="file" name="file" class="form-control" required>

                @if($peserta->getFirstMediaUrl('izin_orangtua'))
                <a href="{{ $peserta->getFirstMediaUrl('izin_orangtua') }}" target="_blank"
                    class="btn btn-secondary mt-2">Lihat Surat Izin Orangtua</a>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <!-- Form untuk Surat Keterangan Sehat -->
        <form method="POST"
            action="{{ route('peserta.upload', ['id' => $peserta->id, 'type' => 'surat_keterangan_sehat']) }}"
            enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="surat_keterangan_sehat" class="form-label">Surat Keterangan Sehat</label>
                <input type="file" name="file" class="form-control" required>

                @if($peserta->getFirstMediaUrl('surat_keterangan_sehat'))
                <a href="{{ $peserta->getFirstMediaUrl('surat_keterangan_sehat') }}" target="_blank"
                    class="btn btn-secondary mt-2">Lihat Surat Keterangan Sehat</a>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

    </div>
</div>