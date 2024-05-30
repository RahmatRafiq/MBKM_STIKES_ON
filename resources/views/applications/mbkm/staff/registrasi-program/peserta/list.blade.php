@extends('layouts.app')

@section('title', 'Daftar Registrasi dan Terima Tawaran')

@section('content')
<div class="list-container">
    <h2>Daftar Registrasi</h2>
    <a href="{{ route('peserta.registrasiForm') }}" class="btn">Form Registrasi</a>
    <table>
        <thead>
            <tr>
                <th>ID Registrasi</th>
                <th>Nama Lowongan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $registration)
            <tr>
                <td>{{ $registration->id }}</td>
                <td>{{ $registration->lowongan->name }}</td>
                <td>{{ $registration->status }}</td>
                <td>
                    @if($registration->status == 'accepted')
                    <form action="{{ route('peserta.acceptOffer', $registration->id) }}" method="POST">
                        @csrf
                        <select name="dospem_id" required>
                            @foreach($dospems as $dospem)
                                <option value="{{ $dospem->id }}">{{ $dospem->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit">Terima Tawaran</button>
                    </form>
                    @else
                    -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
