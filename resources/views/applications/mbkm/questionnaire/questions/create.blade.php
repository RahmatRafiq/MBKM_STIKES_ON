@extends('layouts.app')

@section('title', 'Tambah Pertanyaan Baru')

@section('content')
    <h1>Tambah Pertanyaan Baru</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="question_text">Pertanyaan</label>
            <input type="text" name="question_text" class="form-control" id="question_text" value="{{ old('question_text') }}" required>
        </div>

        <div class="form-group">
            <label for="question_type">Jenis Pertanyaan</label>
            <select name="question_type" class="form-control" id="question_type" required>
                <option value="text" {{ old('question_type') == 'text' ? 'selected' : '' }}>Teks</option>
                <option value="select" {{ old('question_type') == 'select' ? 'selected' : '' }}>Select</option>
                <option value="checkbox" {{ old('question_type') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                <option value="radio" {{ old('question_type') == 'radio' ? 'selected' : '' }}>Radio</option>
            </select>
        </div>

        <div id="options-container" class="form-group" style="display: none;">
            <label>Opsi Jawaban</label>
            <button type="button" class="btn btn-secondary" onclick="addOption()">Tambah Opsi</button>
            <div id="option-template" class="form-group mt-2" style="display: none;">
                <input type="text" name="options[]" class="form-control">
            </div>
            <!-- Tampilkan opsi yang sudah diinput jika ada -->
            @if(old('options'))
                @foreach(old('options') as $option)
                    <div class="form-group">
                        <input type="text" name="options[]" class="form-control mt-2" value="{{ $option }}">
                    </div>
                @endforeach
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

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
