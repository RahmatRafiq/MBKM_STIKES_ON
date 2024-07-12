<!-- resources/views/applications/mbkm/about_mbkms/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="row gx-3">
    <div class="col-xxl-12">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Tentang MBKM</h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('about-mbkms.update') }}" method="POST">
                    @csrf

                    <div class="form-group row mb-3">
                        <label for="program_name" class="col-md-4 col-form-label text-md-right">Program Name</label>
                        <div class="col-md-8">
                            <input id="program_name" type="text" class="form-control @error('program_name') is-invalid @enderror" name="program_name" value="{{ old('program_name', $aboutMbkm->program_name ?? '') }}" required>
                            @error('program_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                        <div class="col-md-8">
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="5" required>{{ old('description', $aboutMbkm->description ?? '') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="duration" class="col-md-4 col-form-label text-md-right">Duration</label>
                        <div class="col-md-8">
                            <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration', $aboutMbkm->duration ?? '') }}">
                            @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="eligibility" class="col-md-4 col-form-label text-md-right">Eligibility</label>
                        <div class="col-md-8">
                            <input id="eligibility" type="text" class="form-control @error('eligibility') is-invalid @enderror" name="eligibility" value="{{ old('eligibility', $aboutMbkm->eligibility ?? '') }}">
                            @error('eligibility')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="benefits" class="col-md-4 col-form-label text-md-right">Benefits</label>
                        <div class="col-md-8">
                            <input id="benefits" type="text" class="form-control @error('benefits') is-invalid @enderror" name="benefits" value="{{ old('benefits', $aboutMbkm->benefits ?? '') }}">
                            @error('benefits')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="contact_email" class="col-md-4 col-form-label text-md-right">Contact Email</label>
                        <div class="col-md-8">
                            <input id="contact_email" type="email" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ old('contact_email', $aboutMbkm->contact_email ?? '') }}">
                            @error('contact_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="contact_phone" class="col-md-4 col-form-label text-md-right">Contact Phone</label>
                        <div class="col-md-8">
                            <input id="contact_phone" type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ old('contact_phone', $aboutMbkm->contact_phone ?? '') }}">
                            @error('contact_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="contact_address" class="col-md-4 col-form-label text-md-right">Contact Address</label>
                        <div class="col-md-8">
                            <input id="contact_address" type="text" class="form-control @error('contact_address') is-invalid @enderror" name="contact_address" value="{{ old('contact_address', $aboutMbkm->contact_address ?? '') }}">
                            @error('contact_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
