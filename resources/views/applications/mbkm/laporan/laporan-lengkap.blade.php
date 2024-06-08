@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Laporan Lengkap</h1>
    <form action="{{ route('laporan.lengkap.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="isi_laporan">Isi Laporan</label>
            <textarea name="isi_laporan" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
