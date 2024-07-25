{{-- @extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('mitra.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Add New Mitra Profile</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="mitra_name" name="mitra_name" required
                                placeholder="Name" value="{{ old('mitra_name') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="mitra_address" name="mitra_address" required
                                placeholder="Address" value="{{ old('mitra_address') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="mitra_phone" name="mitra_phone" required
                                placeholder="Phone" value="{{ old('mitra_phone') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="email" class="form-control" id="mitra_email" name="mitra_email" required
                                    placeholder="Email" value="{{ old('mitra_email') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_website" class="form-label">Website</label>
                            <div class="input-group">
                                <span class="input-group-text">https://</span>
                                <input type="text" class="form-control" id="mitra_website" name="mitra_website"
                                    placeholder="Website" value="{{ old('mitra_website', 'https://') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_type" class="form-label">Type</label>
                            <select class="form-select" id="mitra_type" name="mitra_type" required>
                                @foreach ($types as $type)
                                <option value="{{ $type->id }}" {{ old('mitra_type')==$type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="mitra_description" class="form-label">Description</label>
                            <textarea class="form-control" id="mitra_description" name="mitra_description" required
                                placeholder="Description">{{ old('mitra_description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="images" class="form-label">Images</label>
                            <div class="dropzone" id="myDropzone"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Add User for Mitra</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_name" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" required
                                placeholder="User Name" value="{{ old('user_name') }}">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="same_name">
                                <label class="form-check-label" for="same_name">
                                    Same as Mitra Name
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_email" class="form-label">User Email</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="email" class="form-control" id="user_email" name="user_email" required
                                    placeholder="User Email" value="{{ old('user_email') }}">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="same_email">
                                <label class="form-check-label" for="same_email">
                                    Same as Mitra Email
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="user_password" name="user_password" required
                                placeholder="Password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="user_password_confirmation"
                                name="user_password_confirmation" required placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection

@push('head')
@vite(['resources/js/dropzoner.js'])
@endpush

@push('javascript')
<script type="module">
    // Dropzone setup
        const element = '#myDropzone';
        const key = 'images';
        const files = [];
        const urlStore = "{!! route('storage.store') !!}";
        const urlDestroy = "{!! route('storage.destroy') !!}";
        const csrf = "{!! csrf_token() !!}";
        const acceptedFiles = 'image/*';
        const maxFiles = 3;
        const kind = 'image';

        Dropzoner(
            element,
            key,
            {
                urlStore,
                urlDestroy,
                csrf,
                acceptedFiles,
                files,
                maxFiles,
                kind,
            }
        );

        // Synchronize Mitra Name and Email with User Name and Email
        document.getElementById('same_name').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('user_name').value = document.getElementById('mitra_name').value;
            } else {
                document.getElementById('user_name').value = "{{ old('user_name') }}";
            }
        });

        document.getElementById('same_email').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('user_email').value = document.getElementById('mitra_email').value;
            } else {
                document.getElementById('user_email').value = "{{ old('user_email') }}";
            }
        });
</script>
@endpush --}}




@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('mitra.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Add New Mitra Profile</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="mitra_name" name="mitra_name" required
                                placeholder="Name" value="{{ old('mitra_name') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="mitra_address" name="mitra_address" required
                                placeholder="Address" value="{{ old('mitra_address') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="mitra_phone" name="mitra_phone" required
                                placeholder="Phone" value="{{ old('mitra_phone') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="email" class="form-control" id="mitra_email" name="mitra_email" required
                                    placeholder="Email" value="{{ old('mitra_email') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_website" class="form-label">Website</label>
                            <div class="input-group">
                                <span class="input-group-text">https://</span>
                                <input type="text" class="form-control" id="mitra_website" name="mitra_website"
                                    placeholder="Website" value="{{ old('mitra_website', 'https://') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_type" class="form-label">Type</label>
                            <select class="form-select" id="mitra_type" name="mitra_type" required>
                                @foreach ($types as $type)
                                <option value="{{ $type->id }}" {{ old('mitra_type')==$type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="mitra_description" class="form-label">Description</label>
                            <textarea class="form-control" id="mitra_description" name="mitra_description" required
                                placeholder="Description">{{ old('mitra_description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="images" class="form-label">Images</label>
                            <div class="dropzone" id="myDropzone"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Add User for Mitra</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_name" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" required
                                placeholder="User Name" value="{{ old('user_name') }}">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="same_name">
                                <label class="form-check-label" for="same_name">
                                    Same as Mitra Name
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_email" class="form-label">User Email</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="email" class="form-control" id="user_email" name="user_email" required
                                    placeholder="User Email" value="{{ old('user_email') }}">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="same_email">
                                <label class="form-check-label" for="same_email">
                                    Same as Mitra Email
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="user_password" name="user_password" required
                                placeholder="Password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="user_password_confirmation"
                                name="user_password_confirmation" required placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection

@push('head')
@vite(['resources/js/dropzoner.js'])
@endpush

@push('javascript')
<script type="module">
    // Dropzone setup
        const element = '#myDropzone';
        const key = 'images';
        const files = [];
        const urlStore = "{!! route('storage.store') !!}";
        const urlDestroy = "{!! route('storage.destroy') !!}";
        const csrf = "{!! csrf_token() !!}";
        const acceptedFiles = 'image/*';
        const maxFiles = 3;
        const kind = 'image';

        Dropzoner(
            element,
            key,
            {
                urlStore,
                urlDestroy,
                csrf,
                acceptedFiles,
                files,
                maxFiles,
                kind,
            }
        );

        // Synchronize Mitra Name and Email with User Name and Email
        document.getElementById('same_name').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('user_name').value = document.getElementById('mitra_name').value;
            } else {
                document.getElementById('user_name').value = "{{ old('user_name') }}";
            }
        });

        document.getElementById('same_email').addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('user_email').value = document.getElementById('mitra_email').value;
            } else {
                document.getElementById('user_email').value = "{{ old('user_email') }}";
            }
        });
</script>
@endpush
