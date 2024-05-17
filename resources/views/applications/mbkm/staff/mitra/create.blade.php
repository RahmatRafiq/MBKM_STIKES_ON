
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
                    <div class="mb-3">
                        <label for="mitra_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="mitra_name" name="mitra_name" required
                            placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <label for="mitra_address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="mitra_address" name="mitra_address" required
                            placeholder="Address">
                    </div>
                    <div class="mb-3">
                        <label for="mitra_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="mitra_phone" name="mitra_phone" required
                            placeholder="Phone">
                    </div>
                    <div class="mb-3">
                        <label for="mitra_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="mitra_email" name="mitra_email" required
                            placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <label for="mitra_website" class="form-label">Website</label>
                        <input type="text" class="form-control" id="mitra_website" name="mitra_website" placeholder="Website">
                    </div>
                    <div class="mb-3">
                        <label for="mitra_type" class="form-label">Type</label>
                        <select class="form-select" id="mitra_type" name="mitra_type" required>
                            <option value="Magang Merdeka">Magang Merdeka</option>
                            <option value="Kampus Mengajar">Kampus Mengajar</option>
                            <option value="Pertukaran Mahasiswa">Pertukaran Mahasiswa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mitra_description" class="form-label">Description</label>
                        <textarea class="form-control" id="mitra_description" name="mitra_description" required placeholder="Description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="mitra_images" class="form-label">Images</label>
                        <input type="file" class="form-control" id="mitra_images" name="mitra_images[]" multiple>
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
                    <div class="mb-3">
                        <label for="user_name" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" required
                            placeholder="User Name">
                    </div>
                    <div class="mb-3">
                        <label for="user_email" class="form-label">User Email</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" required
                            placeholder="User Email">
                    </div>
                    <div class="mb-3">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="user_password" name="user_password" required
                            placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <label for="user_password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="user_password_confirmation"
                            name="user_password_confirmation" required placeholder="Confirm Password">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role_id" required>
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

