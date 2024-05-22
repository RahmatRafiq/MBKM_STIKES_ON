{{-- @extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Create New Dosen Pembimbing Lapangan</div>
        <div class="card-body">
            <form method="POST" action="{{ route('dospem.store') }}">
                @csrf
                <div class="form-group">
                    <label for="dosen_id">Dosen</label>
                    <select name="dosen_id" id="dosen_id" class="form-control" required>
                        <option value="">Pilih Dosen</option>
                        @foreach ($dosen as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }} - {{ $item->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
            
        </div>
    </div>
@endsection --}}
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Create New Dosen Pembimbing Lapangan</div>
        <div class="card-body">
            <form method="POST" action="{{ route('dospem.store') }}">
                @csrf
                <div class="form-group">
                    <label for="dosen_id">Dosen</label>
                    <select name="dosen_id" id="dosen_id" class="form-control @error('dosen_id') is-invalid @enderror" required>
                        <option value="">Pilih Dosen</option>
                        @foreach ($dosen as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }} - {{ $item->email }}</option>
                        @endforeach
                    </select>
                    @error('dosen_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
@endsection
