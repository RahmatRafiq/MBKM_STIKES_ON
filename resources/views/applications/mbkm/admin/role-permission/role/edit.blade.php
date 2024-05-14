@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-3">
        <div class="card-body">
            <h1>Edit Role</h1>

            <form action="{{ route('role.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-xxl-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $role->role }}">
                            </div>
                            <div class="mb-3">
                                <label for="guard_name" class="form-label">Guard Name</label>
                                <input type="text" class="form-control" id="guard_name" name="guard_name" value="{{ $role->guard_name }}">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Role</button>
            </form>
        </div>
    </div>
</div>
@endsection
