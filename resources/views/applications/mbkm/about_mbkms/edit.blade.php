@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit About MBKM</h1>
    <form action="{{ route('about-mbkms.update', $aboutMbkm->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="program_name">Program Name</label>
            <input type="text" class="form-control" id="program_name" name="program_name" value="{{ $aboutMbkm->program_name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>{{ $aboutMbkm->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="duration">Duration</label>
            <input type="text" class="form-control" id="duration" name="duration" value="{{ $aboutMbkm->duration }}">
        </div>
        <div class="form-group">
            <label for="eligibility">Eligibility</label>
            <input type="text" class="form-control" id="eligibility" name="eligibility" value="{{ $aboutMbkm->eligibility }}">
        </div>
        <div class="form-group">
            <label for="benefits">Benefits</label>
            <input type="text" class="form-control" id="benefits" name="benefits" value="{{ $aboutMbkm->benefits }}">
        </div>
        <div class="form-group">
            <label for="contact_email">Contact Email</label>
            <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ $aboutMbkm->contact_email }}">
        </div>
        <div class="form-group">
            <label for="contact_phone">Contact Phone</label>
            <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="{{ $aboutMbkm->contact_phone }}">
        </div>
        <div class="form-group">
            <label for="contact_address">Contact Address</label>
            <input type="text" class="form-control" id="contact_address" name="contact_address" value="{{ $aboutMbkm->contact_address }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
