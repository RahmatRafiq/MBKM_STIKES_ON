@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Tambah Data Lowongan</h5>
            </div>
            <form action="{{ route('lowongan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="mitra_id" class="form-label">Mitra</label>
                    <select class="form-control" id="mitra_id" name="mitra_id">
                        @foreach ($mitraProfile as $mitra)
                            <option value="{{ $mitra->id }}">{{ $mitra->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="quota" class="form-label">Quota</label>
                    <input type="number" class="form-control" id="quota" name="quota">
                </div>
                <div class="mb-3">
                    <label for="is_open" class="form-label">Status</label>
                    <select class="form-control" id="is_open" name="is_open">
                        <option value="1">Open</option>
                        <option value="0">Closed</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="location" name="location">
                </div>
                <div class="mb-3">
                    <label for="gpa" class="form-label">IPK</label>
                    <input type="text" class="form-control" id="gpa" name="gpa">
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select class="form-control" id="semester" name="semester">
                        @for ($i = 1; $i <= 14; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3">
                    <label for="experience_required" class="form-label">Pengalaman</label>
                    <input type="text" class="form-control" id="experience_required" name="experience_required">
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">Tanggal Berakhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
