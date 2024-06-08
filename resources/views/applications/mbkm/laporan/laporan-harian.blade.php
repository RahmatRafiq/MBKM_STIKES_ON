@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Isi Laporan Harian</h2>
    <form action="{{ route('laporan.harian.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="isi_laporan">Isi Laporan</label>
            <textarea name="isi_laporan" id="isi_laporan" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="kehadiran">Kehadiran</label>
            <select name="kehadiran" id="kehadiran" class="form-control" required>
                <option value="hadir">Hadir</option>
                <option value="tidak hadir">Tidak Hadir</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection

