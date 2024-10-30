@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Create New Dosen Pembimbing Lapangan</div>
        <div class="card-body">
            <form method="POST" action="{{ route('dospem.store') }}">
                @csrf
                <div class="row gx-3">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="m-0">
                                    <label for="dosen_id" class="form-label">Dosen</label>
                                    <select name="dosen_id" id="dosen_id"
                                        class="form-select @error('dosen_id') is-invalid @enderror" required>
                                        <option value="">Pilih Dosen</option>
                                        @foreach ($dosen as $item)
                                            <option value="{{ $item->Login }}"
                                                {{ old('dosen_id') == $item->Login ? 'selected' : '' }}>
                                                {{ $item->Nama }} - NIP: {{ $item->nip }} - {{ $item->Email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dosen_id')
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
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
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
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
@endsection
