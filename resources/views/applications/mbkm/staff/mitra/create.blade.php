@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Add New Mitra</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('mitra.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Name"
                            value="{{ old('name') }}" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required placeholder="Address"
                            value="{{ old('address') }}">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required placeholder="Phone"
                            value="{{ old('phone') }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Email"
                            value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="text" class="form-control" id="website" name="website" placeholder="Website"
                            value="{{ old('website') }}">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required
                            value="{{ old('type') }}">
                            <option value="Magang Merdeka">Magang Merdeka</option>
                            <option value="Kampus Mengajar">Kampus Mengajar</option>
                            <option value="Pertukaran Mahasiswa">Pertukaran Mahasiswa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required placeholder="Description">
                            {{ old('description') }}
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Images</label>
                        <div class="dropzone" id="myDropzone"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Mitra</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('head')
@vite(['resources/js/dropzoner.js'])
@endpush
@push('javascript')
    <script type="module">
        // dropzone
        const element = '#myDropzone'
        const key = 'images'
        const files = []
        const urlStore = "{!! route('storage.store') !!}"
        const urlDestroy = "{!! route('storage.destroy') !!}"
        const csrf = "{!! csrf_token() !!}"
        const acceptedFiles = 'image/*'
        const maxFiles = 3
        const kind = 'image'

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
        )
    </script>
@endpush