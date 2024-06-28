@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Add New Batch MBKM</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('batch-mbkms.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <label for="semester_start" class="form-label">Semester Start</label>
                        <input type="date" class="form-control" id="semester_start" name="semester_start" required>
                    </div>
                    <div class="mb-3">
                        <label for="semester_end" class="form-label">Semester End</label>
                        <input type="date" class="form-control" id="semester_end" name="semester_end" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Batch MBKM</button>
                </form>
            </div>
        </div>
    </div>
@endsection
