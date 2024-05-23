@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Edit Dosen Pembimbing Lapangan</div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('dospem.update', $dosenPembimbingLapangan->id) }}">
                @csrf
                @method('PUT')
                <div class="row gx-3">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="m-0">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $dosenPembimbingLapangan->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                                    @error('name')
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
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" name="nip" id="nip" value="{{ old('nip', $dosenPembimbingLapangan->nip) }}" class="form-control @error('nip') is-invalid @enderror" required>
                                    @error('nip')
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
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" name="address" id="address" value="{{ old('address', $dosenPembimbingLapangan->address) }}" class="form-control @error('address') is-invalid @enderror" required>
                                    @error('address')
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
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $dosenPembimbingLapangan->phone) }}" class="form-control @error('phone') is-invalid @enderror" required>
                                    @error('phone')
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
@endsection
