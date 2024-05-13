@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Create New Permission</h1>

    <form action="{{ route('permission.store') }}" method="POST">
        @csrf

        <div class="col-xxl-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Permission Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guard Name</label>
                        <select class="form-select" id="guard_name" name="guard_name">
                            <option value="">Select Guard Name</option>
                            @foreach (App\Helpers\Guards::list() as $guard_name)
                                <option value="{{ $guard_name }}" {{ old('name') == $guard_name ? 'selected' : '' }}>{{ $guard_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Create Permission</button>
    </form>
</div>

@endsection
