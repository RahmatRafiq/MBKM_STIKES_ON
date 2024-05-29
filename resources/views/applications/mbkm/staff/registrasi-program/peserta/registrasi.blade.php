<!-- resources/views/applications/mbkm/staff/registrasi-program/peserta/registrasi.blade.php -->
{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrasi Peserta</h2>
    <form action="{{ route('peserta.registrasi') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="peserta_id">ID Peserta</label>
            <input type="text" class="form-control" id="peserta_id" name="peserta_id" value="{{ auth()->user()->id }}" readonly>
        </div>
        <div class="form-group">
            <label for="lowongan_id">Pilih Lowongan</label>
            <select class="form-control" id="lowongan_id" name="lowongan_id">
                @foreach ($lowongans as $lowongan)
                    <option value="{{ $lowongan->id }}">{{ $lowongan->name }} - {{ $lowongan->mitra->type }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrasi Peserta</h2>
    <div class="row">
        @foreach ($lowongans as $lowongan)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h4 class="card-title mb-2">{{ $lowongan->name }}</h4>
                        <h6 class="card-subtitle text-muted mb-0">{{ $lowongan->mitra->type }}</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('peserta.registrasi') }}" method="POST">
                            @csrf
                            <input type="hidden" name="peserta_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="lowongan_id" value="{{ $lowongan->id }}">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrasi Peserta</h2>
    <div class="row">
        @foreach ($lowongans as $lowongan)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h4 class="card-title mb-2">{{ $lowongan->name }}</h4>
                        <h6 class="card-subtitle text-muted mb-0">{{ $lowongan->mitra->type }}</h6>
                    </div>
                    <div class="card-body">
                        <p>{{ $lowongan->description }}</p>
                        <form action="{{ route('peserta.registrasi') }}" method="POST">
                            @csrf
                            <input type="hidden" name="peserta_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="lowongan_id" value="{{ $lowongan->id }}">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

