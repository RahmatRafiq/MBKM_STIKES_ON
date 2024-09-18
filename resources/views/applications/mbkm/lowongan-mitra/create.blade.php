@extends('layouts.app')

@section('content')
<form action="{{ route('lowongan.store') }}" method="POST">
    @csrf
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Tambah Data Lowongan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mitra_id" class="form-label">Mitra</label>
                            @if(auth()->user()->hasRole('mitra'))
                            <input type="hidden" name="mitra_id" value="{{ $mitraProfile->first()->id }}">
                            <input type="text" class="form-control" value="{{ $mitraProfile->first()->name }}" readonly>
                            @else
                            <select class="form-control" id="mitra_id" name="mitra_id">
                                @foreach ($mitraProfile as $mitra)
                                <option value="{{ $mitra->id }}" {{ old('mitra_id')==$mitra->id ? 'selected' : '' }}>
                                    {{ $mitra->name }}
                                </option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="is_open" class="form-label">Status</label>
                            <select class="form-control" id="is_open" name="is_open">
                                <option value="1" {{ old('is_open')=='1' ? 'selected' : '' }}>Open</option>
                                <option value="0" {{ old('is_open')=='0' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-control" id="semester" name="semester">
                                @for ($i = 1; $i <= 14; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description"
                                name="description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="gpa" class="form-label">IPK</label>
                            <input type="text" class="form-control" id="gpa" name="gpa" value="{{ old('gpa') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quota" class="form-label">Quota</label>
                            <input type="number" class="form-control" id="quota" name="quota"
                                value="{{ old('quota') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="location" name="location"
                                value="{{ old('location') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="experience_required" class="form-label">Pengalaman</label>
                            <input type="text" class="form-control" id="experience_required" name="experience_required"
                                value="{{ old('experience_required') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ old('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ old('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="matakuliah_id" class="form-label">Pilih Mata Kuliah</label>
                            <select class="form-control" id="matakuliah_id" name="matakuliah_id[]" multiple="multiple">
                                @foreach ($matakuliahs as $matakuliah)
                                <option value="{{ $matakuliah->MKID }}" {{ in_array($matakuliah->MKID,
                                    old('matakuliah_id', [])) ? 'selected' : '' }}>
                                    {{ $matakuliah->Nama }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('matakuliah_id'))
                            <span class="text-danger">{{ $errors->first('matakuliah_id') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection
@push('css')
<link href="{{ asset('assets/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('javascript')
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#matakuliah_id').select2({  // Sesuaikan ID di sini
            placeholder: "Pilih Mata Kuliah",
            allowClear: true
        });
    });
</script>
@endpush