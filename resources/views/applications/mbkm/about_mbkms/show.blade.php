@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $aboutMbkm->program_name }}</h1>
    <p>{{ $aboutMbkm->description }}</p>
    <p><strong>Duration:</strong> {{ $aboutMbkm->duration }}</p>
    <p><strong>Eligibility:</strong> {{ $aboutMbkm->eligibility }}</p>
    <p><strong>Benefits:</strong> {{ $aboutMbkm->benefits }}</p>
    <p><strong>Contact Email:</strong> {{ $aboutMbkm->contact_email }}</p>
    <p><strong>Contact Phone:</strong> {{ $aboutMbkm->contact_phone }}</p>
    <p><strong>Contact Address:</strong> {{ $aboutMbkm->contact_address }}</p>
    <a href="{{ route('about-mbkms.index') }}" class="btn btn-primary">Back</a>
</div>
@endsection
