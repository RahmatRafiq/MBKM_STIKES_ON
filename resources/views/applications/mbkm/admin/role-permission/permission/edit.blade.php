@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Edit Permission</h1>

    <form action="{{ route('permission.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-xxl-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Permission Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guard Name</label>
                        <input type="text" class="form-control" id="guard_name" name="guard_name"
                            value="{{ $permission->guard_name }}">
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Permission</button>
    </form>
</div>

@endsection