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
    </div>
</div>