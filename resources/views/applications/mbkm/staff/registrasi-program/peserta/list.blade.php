@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Registrasi Peserta</div>

                <div class="card-body">
                    <h5>Detail Registrasi</h5>
                    <p>Lowongan: {{ $registration->lowongan->nama }}</p>
                    <p>Status: {{ $registration->status }}</p>

                    @if ($registration->status == 'accepted')
                    <p>Dosen Pembimbing: {{ $registration->dospem_id }}</p>
                    @endif

                    <hr>

                    <h5>Registrasi Lainnya</h5>
                    <ul>
                        @foreach($registrations as $reg)
                        <li>{{ $reg->lowongan->nama }} - {{ $reg->status }}</li>
                        @endforeach
                    </ul>

                    <hr>

                    @if ($registration->status == 'processed')
                    <h5>Terima Tawaran</h5>
                    <form method="post" action="{{ route('peserta.acceptOffer', $registration->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="dospem_id">Pilih Dosen Pembimbing:</label>
                            <select name="dospem_id" class="form-control">
                                @foreach($dospems as $dospem)
                                <option value="{{ $dospem->id }}">{{ $dospem->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Terima Tawaran</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

