@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Edit Batch MBKM</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('batch-mbkms.update', $batch->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Name" value="{{ old('name', $batch->name) }}">
                    </div>
                    <div class="mb-3">
                        <label for="semester_start" class="form-label">Semester Start</label>
                        <input type="date" class="form-control" id="semester_start" name="semester_start" required value="{{ old('semester_start', $batch->semester_start) }}">
                    </div>
                    <div class="mb-3">
                        <label for="semester_end" class="form-label">Semester End</label>
                        <input type="date" class="form-control" id="semester_end" name="semester_end" required value="{{ old('semester_end', $batch->semester_end) }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Batch MBKM</button>
                </form>
            </div>
        </div>
    </div>
@endsection
