@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Edit Mitra</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('mitra.update', $item->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required
                            value="{{ old('name') ?? $item->name }}" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required
                            value="{{ old('address') ?? $item->address }}">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required
                            value="{{ old('phone') ?? $item->phone }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required
                            value="{{ old('email') ?? $item->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="text" class="form-control" id="website" name="website"
                            value="{{ old('website') ?? $item->website }}">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" id="type" name="type" required
                            value="{{ old('type') ?? $item->type }}">
                            <option value="Magang Merdeka" {{ $item->type == 'Magang Merdeka' ? 'selected' : '' }}>
                                Magang Merdeka</option>
                            <option value="Kampus Mengajar"
                                {{ $item->type == 'Kampus Mengajar' ? 'selected' : '' }}>Kampus Mengajar</option>
                            <option value="Pertukaran Mahasiswa"
                                {{ $item->type == 'Pertukaran Mahasiswa' ? 'selected' : '' }}>Pertukaran Mahasiswa
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required>{{ old('description') ?? $item->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Images</label>
                        {{-- @dd($item->getMedia()[0]->getFullUrl()) --}}
                        {{-- @if ($item->getMedia())
                            <div class="mb-2">
                                @foreach (json_decode($item->getMedia()) as $image)
                                    <img src="{{ $image->original_url }}" alt="Current Image"
                                        style="max-width: 200px; margin-right: 10px;">
                                @endforeach
                            </div>
                        @endif --}}
                        {{-- dropzone --}}
                        <div class="dropzone" id="myDropzone"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Mitra</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/dropzone/dropzone.min.css') }}">
@endpush

@push('javascript')
    <script src="{{ asset('assets/vendor/dropzone/dropzone.min.js') }}"></script>

    <script>
        const key = window.location.pathname
        // dropzone
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#myDropzone", {
            url: "{{ route('storage.store') }}",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            acceptedFiles: 'image/*',
            maxFiles: 3,
            addRemoveLinks: true,
            init: function () {

                @if ($item->getMedia('images'))
                    let input = document.createElement('input')
                    @foreach ($item->getMedia('images') as $image)
                        var mockFile = {
                            name: "{{ $image->file_name }}",
                            size: {{ $image->size }},
                            accepted: true,
                            kind: 'image',
                            upload: {
                                filename: "{{ $image->file_name }}",
                                size: {{ $image->size }}
                            },
                            dataURL: "{{ $image->getFullUrl() }}"
                        };
                        this.emit("addedfile", mockFile);
                        this.emit("thumbnail", mockFile, "{{ $image->getFullUrl() }}");
                        this.emit("complete", mockFile);

                        input = document.createElement('input')
                        input.setAttribute('type', 'hidden')
                        input.setAttribute('name', 'images[]')
                        input.setAttribute('value', "{{ $image->file_name }}")
                        mockFile.previewElement.appendChild(input)
                    @endforeach
                @endif
            },
            success: function (file, response) {
                file.upload.filename = response.name
                file.upload.size = response.size

                const input = document.createElement('input')
                input.setAttribute('type', 'hidden')
                input.setAttribute('name', 'images[]')
                input.setAttribute('value', response.name)
                file.previewElement.appendChild(input)
            },
            removedfile: function (file) {
                const name = file.upload.filename
                const size = file.upload.size
                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('storage.destroy') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        filename: file.name,
                    },
                    success: function (data) {
                        console.log(data)
                    },
                    error: function (e) {
                        console.log(e)
                    }
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }
        });

        // detect window refresh
        window.addEventListener('beforeunload', function (e) {
            myDropzone.removeAllFiles(true);
        });
    </script>
@endpush
