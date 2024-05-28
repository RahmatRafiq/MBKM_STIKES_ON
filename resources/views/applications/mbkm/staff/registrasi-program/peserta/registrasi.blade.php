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


@extends('layouts.app')

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <h4 class="card-title mb-2">Registrasi Peserta</h4>
        <h6 class="card-subtitle text-muted mb-0">Registrasi Peserta ke Program</h6>
    </div>
    <img src="#" class="img-fluid" alt="Bootstrap Gallery">
    <div class="card-body position-relative pt-4">
        <a href="#" class="btn btn-danger card-btn-floating">
            <i class="bi bi-plus-lg m-0"></i>
        </a>
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
            <div class="form-group">
                <button type="submit" class="btn btn-primary mt-3">Daftar</button>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <a href="#" class="btn btn-danger">Find Out More!</a> 
        <a href="#" class="btn btn-info">Find Out More!</a>
    </div>
</div>

@endsection
