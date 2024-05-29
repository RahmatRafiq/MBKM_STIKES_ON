
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
