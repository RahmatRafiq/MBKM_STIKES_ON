@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Edit Lowongan</h5>
            </div>
            <form action="{{ route('lowongan.update', $lowongan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $lowongan->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="mitra_id" class="form-label">Mitra ID</label>
                    <input type="number" class="form-control" id="mitra_id" name="mitra_id" value="{{ $lowongan->mitra_id }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" required>{{ $lowongan->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="quota" class="form-label">Quota</label>
                    <input type="number" class="form-control" id="quota" name="quota" value="{{ $lowongan->quota }}" required>
                </div>
                <div class="mb-3">
                    <label for="is_open" class="form-label">Status</label>
                    <select class="form-control" id="is_open" name="is_open" required>
                        <option value="1" {{ $lowongan->is_open ? 'selected' : '' }}>Open</option>
                        <option value="0" {{ !$lowongan->is_open ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ $lowongan->location }}" required>
                </div>
                <div class="mb-3">
                    <label for="gpa" class="form-label">IPK</label>
                    <input type="text" class="form-control" id="gpa" name="gpa" value="{{ $lowongan->gpa }}" required>
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select class="form-control" id="semester" name="semester" required>
                        @for ($i = 1; $i <= 14; $i++)
                            <option value="{{ $i }}" {{ $lowongan->semester == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3">
                    <label for="experience_required" class="form-label">Pengalaman yang Dibutuhkan</label>
                    <input type="text" class="form-control" id="experience_required" name="experience_required" value="{{ $lowongan->experience_required }}" required>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $lowongan->start_date }}" required>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">Tanggal Berakhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $lowongan->end_date }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Lowongan</button>
            </form>
        </div>
    </div>
@endsection
