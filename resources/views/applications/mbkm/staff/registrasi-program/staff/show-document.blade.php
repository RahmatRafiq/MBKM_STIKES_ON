@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Dokumen Peserta: {{ $peserta->nama }}</h5> <!-- Langsung pakai heading, bukan card-title -->
    </div>
    <div class="card-body">
        <!-- Tambahkan card-body untuk konten utama -->
        <div class="table-responsive">
            <table class="table styled-table">
                <thead>
                    <tr>
                        <th>Nama Dokumen</th>
                        <th>Nama File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($documents as $document)
                    <tr>
                        <td>{{ $document->label }}</td> <!-- Nama dokumen deskriptif -->
                        <td>{{ $document->file_name }}</td> <!-- Nama file asli -->
                        <td>
                            <a href="{{ $document->url }}" class="btn btn-primary" target="_blank">Lihat</a>
                            <a href="{{ $document->url }}" class="btn btn-success" download>Download</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">Tidak ada dokumen yang diunggah.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <a href="{{ route('staff.registrasiIndex') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection