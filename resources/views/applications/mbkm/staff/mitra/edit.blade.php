@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Edit Mitra</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('mitra.update', $mitraProfile->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required
                            value="{{ $mitraProfile->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required
                            value="{{ $mitraProfile->address }}">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required
                            value="{{ $mitraProfile->phone }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required
                            value="{{ $mitraProfile->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="text" class="form-control" id="website" name="website"
                            value="{{ $mitraProfile->website }}">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="Magang Merdeka" {{ $mitraProfile->type == 'Magang Merdeka' ? 'selected' : '' }}>
                                Magang Merdeka</option>
                            <option value="Kampus Mengajar"
                                {{ $mitraProfile->type == 'Kampus Mengajar' ? 'selected' : '' }}>Kampus Mengajar</option>
                            <option value="Pertukaran Mahasiswa"
                                {{ $mitraProfile->type == 'Pertukaran Mahasiswa' ? 'selected' : '' }}>Pertukaran Mahasiswa
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required>{{ $mitraProfile->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Images</label>
                        @if ($mitraProfile->images)
                            <div class="mb-2">
                                @foreach (json_decode($mitraProfile->images) as $image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="Current Image"
                                        style="max-width: 200px; margin-right: 10px;">
                                @endforeach
                            </div>
                        @endif
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Mitra</button>
                </form>
            </div>
        </div>
    </div>
@endsection
