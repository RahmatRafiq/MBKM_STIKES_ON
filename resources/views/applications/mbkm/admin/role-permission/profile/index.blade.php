@extends('layouts.app')

@section('content')
<div class="row gx-3">
    <div class="col-xxl-12">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Profile</h5>
            </div>
            <div class="card-body">
                <!-- Update Profile Information Form -->
                <div class="row gx-3 mb-4">
                    <div class="col-lg-12 col-sm-12 col-12">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <!-- Name Input -->
                            <div class="form-group row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="col-md-8">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email Input -->
                            <div class="form-group row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address')
                                    }}</label>
                                <div class="col-md-8">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', $user->email) }}" required autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group row mb-3">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Profile') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Update Password Form -->
                <div class="row gx-3 mb-4">
                    <div class="col-lg-12 col-sm-12 col-12">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <!-- Current Password Input -->
                            <div class="form-group row mb-3">
                                <label for="current_password" class="col-md-4 col-form-label text-md-right">{{
                                    __('Current Password') }}</label>
                                <div class="col-md-8">
                                    <input id="current_password" type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        name="current_password" required autocomplete="current-password">
                                    @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- New Password Input -->
                            <div class="form-group row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New
                                    Password') }}</label>
                                <div class="col-md-8">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password Input -->
                            <div class="form-group row mb-3">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{
                                    __('Confirm Password') }}</label>
                                <div class="col-md-8">
                                    <input id="password_confirmation" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group row mb-3">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete User Form -->
                <div class="row gx-3">
                    <div class="col-lg-12 col-sm-12 col-12">
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')

                            <!-- Password Confirmation Input -->
                            <div class="form-group row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password')
                                    }}</label>
                                <div class="col-md-8">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group row mb-3">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('Delete Account') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Include Edit Peserta Form -->
            </div>
        </div>
        @if(auth()->user()->peserta)
        <div class="row gx-3 mt-4">
            <div class="col-lg-12 col-sm-12 col-12">
                @include('applications.mbkm.peserta.edit', ['peserta' => auth()->user()->peserta])
            </div>
        </div>
        @endif
    </div>
</div>
@endsection