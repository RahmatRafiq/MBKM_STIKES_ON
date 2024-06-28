@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Batch MBKM</h1>
    <form action="{{ route('batch-mbkms.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="semester_start">Semester Start</label>
            <input type="date" name="semester_start" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="semester_end">Semester End</label>
            <input type="date" name="semester_end" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
