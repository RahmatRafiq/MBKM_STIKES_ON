@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('mitra.update', $item->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Edit Mitra</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                value="{{ old('name') ?? $item->name }}" autofocus>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required
                                value="{{ old('address') ?? $item->address }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required
                                value="{{ old('phone') ?? $item->phone }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="email" class="form-control" id="email" name="email" required
                                    value="{{ old('email') ?? $item->email }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <div class="input-group">
                                <span class="input-group-text">https://</span>
                                <input type="text" class="form-control" id="website" name="website"
                                    value="{{ old('website') ?? $item->website }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="Magang Merdeka" {{ $item->type == 'Magang Merdeka' ? 'selected' : ''
                                    }}>Magang Merdeka</option>
                                <option value="Kampus Mengajar" {{ $item->type == 'Kampus Mengajar' ? 'selected' : ''
                                    }}>Kampus Mengajar</option>
                                <option value="Pertukaran Mahasiswa" {{ $item->type == 'Pertukaran Mahasiswa' ?
                                    'selected' : '' }}>Pertukaran Mahasiswa</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"
                                required>{{ old('description') ?? $item->description }}</textarea>
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

    <button type="submit" class="btn btn-primary">Update Mitra</button>
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

    @foreach ($item->getMedia('images') as $image)
        files.push({
            id: '{{ $image->id }}',
            name: '{{ $image->name }}',
            file_name: '{{ $image->file_name }}',
            size: '{{ $image->size }}',
            type: '{{ $image->type }}',
            url: '{{ $image->getUrl() }}',
            original_url: '{{ $image->getFullUrl() }}',
        })
    @endforeach

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
</script>
@endpush