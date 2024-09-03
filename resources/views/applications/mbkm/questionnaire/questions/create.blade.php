@extends('layouts.app')

@section('title', 'Tambah Pertanyaan Baru')

@section('content')
<form action="{{ route('questions.store') }}" method="POST">
    @csrf
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Tambah Pertanyaan Baru</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="question_text" class="form-label">Pertanyaan</label>
                    <input type="text" name="question_text" class="form-control" id="question_text" value="{{ old('question_text') }}" required>
                </div>

                <div class="mb-3">
                    <label for="question_type" class="form-label">Jenis Pertanyaan</label>
                    <select name="question_type" class="form-select" id="question_type" required>
                        <option value="text" {{ old('question_type') == 'text' ? 'selected' : '' }}>Teks</option>
                        <option value="select" {{ old('question_type') == 'select' ? 'selected' : '' }}>Select</option>
                        <option value="checkbox" {{ old('question_type') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                        <option value="radio" {{ old('question_type') == 'radio' ? 'selected' : '' }}>Radio</option>
                    </select>
                </div>

                <div id="options-container" class="mb-3" style="display: none;">
                    <label class="form-label">Opsi Jawaban</label>
                    <button type="button" class="btn btn-secondary mb-2" onclick="addOption()">Tambah Opsi</button>
                    <div id="option-template" class="mb-2" style="display: none;">
                        <input type="text" name="options[]" class="form-control">
                    </div>
                    @if(old('options'))
                        @foreach(old('options') as $option)
                            <div class="mb-2">
                                <input type="text" name="options[]" class="form-control" value="{{ $option }}">
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- JavaScript untuk menambahkan opsi -->
<script>
    document.getElementById('question_type').addEventListener('change', function () {
        var optionsContainer = document.getElementById('options-container');
        if (['select', 'checkbox', 'radio'].includes(this.value)) {
            optionsContainer.style.display = 'block';
        } else {
            optionsContainer.style.display = 'none';
            // Bersihkan nilai input dari opsi jika user berganti ke 'text'
            var optionInputs = document.querySelectorAll('input[name="options[]"]');
            optionInputs.forEach(function(input) {
                input.value = '';
            });
        }
    });

    function addOption() {
        var template = document.getElementById('option-template');
        var clone = template.cloneNode(true);
        clone.style.display = 'block';

        // Langsung tambahkan opsi tanpa memeriksa input sebelumnya
        document.getElementById('options-container').appendChild(clone);
    }

    // Memastikan opsi tampil jika old() memiliki nilai atau ketika form di-load ulang
    document.addEventListener('DOMContentLoaded', function() {
        var questionType = document.getElementById('question_type').value;
        if (['select', 'checkbox', 'radio'].includes(questionType)) {
            document.getElementById('options-container').style.display = 'block';
        }
    });
</script>
@endsection
