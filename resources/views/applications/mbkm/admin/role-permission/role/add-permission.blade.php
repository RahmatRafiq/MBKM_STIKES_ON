@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Role {{ $role->name }}</h1>

        <form action="{{ route('role.addPermission', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-xxl-12">
                <div class="card mb-3">
                    <div class="card-body">
                        @foreach ($permissions as $permission)
                            <div class="mb-3">
                                <label class="form-label">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Permission</button>
        </form>
    </div>
@endsection
