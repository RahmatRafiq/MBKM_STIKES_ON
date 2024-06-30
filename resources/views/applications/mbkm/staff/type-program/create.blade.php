@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Add New Type Program</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('type-programs.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required placeholder="Description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Type Program</button>
                </form>
            </div>
        </div>
    </div>
@endsection