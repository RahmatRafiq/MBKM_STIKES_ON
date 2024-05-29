@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manajemen Registrasi</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Registrasi</th>
                <th>Nama Peserta</th>
                <th>Lowongan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $registration)
                <tr>
                    <td>{{ $registration->id }}</td>
                    <td>{{ optional($registration->peserta)->nama }}</td>
                    <td>{{ optional($registration->lowongan)->name }}</td>
                    <td>{{ $registration->status }}</td>
                    <td>
                        <form action="{{ route('staff.updateRegistrasi', $registration->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control">
                                <option value="registered" @if($registration->status == 'registered') selected @endif>Didaftar</option>
                                <option value="processed" @if($registration->status == 'processed') selected @endif>Diproses</option>
                                <option value="accepted" @if($registration->status == 'accepted') selected @endif>Diterima</option>
                                <option value="rejected" @if($registration->status == 'rejected') selected @endif>Ditolak</option>
                            </select>
                            <button type="submit" class="btn btn-success mt-2">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
