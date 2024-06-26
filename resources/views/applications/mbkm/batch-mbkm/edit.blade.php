@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Batch MBKM</h1>
    <form action="{{ route('batch-mbkms.update', $batchMbkm->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $batchMbkm->name }}" required>
        </div>
        <div class="form-group">
            <label for="semester_start">Semester Start</label>
            <input type="date" name="semester_start" class="form-control" value="{{ $batchMbkm->semester_start }}" required>
        </div>
        <div class="form-group">
            <label for="semester_end">Semester End</label>
            <input type="date" name="semester_end" class="form-control" value="{{ $batchMbkm->semester_end }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
