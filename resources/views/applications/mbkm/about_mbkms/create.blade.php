@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New About MBKM</h1>
    <form action="{{ route('about-mbkms.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="program_name">Program Name</label>
            <input type="text" class="form-control" id="program_name" name="program_name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="duration">Duration</label>
            <input type="text" class="form-control" id="duration" name="duration">
        </div>
        <div class="form-group">
            <label for="eligibility">Eligibility</label>
            <input type="text" class="form-control" id="eligibility" name="eligibility">
        </div>
        <div class="form-group">
            <label for="benefits">Benefits</label>
            <input type="text" class="form-control" id="benefits" name="benefits">
        </div>
        <div class="form-group">
            <label for="contact_email">Contact Email</label>
            <input type="email" class="form-control" id="contact_email" name="contact_email">
        </div>
        <div class="form-group">
            <label for="contact_phone">Contact Phone</label>
            <input type="text" class="form-control" id="contact_phone" name="contact_phone">
        </div>
        <div class="form-group">
            <label for="contact_address">Contact Address</label>
            <input type="text" class="form-control" id="contact_address" name="contact_address">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
