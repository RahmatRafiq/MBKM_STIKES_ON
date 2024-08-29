@extends('layouts.app')

@section('title', 'Edit Pertanyaan')

@section('content')
    <h1>Edit Pertanyaan</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('questions.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="question_text">Pertanyaan</label>
            <input type="text" name="question_text" class="form-control" id="question_text" value="{{ $question->question_text }}" required>
        </div>

        <div class="form-group">
            <label for="question_type">Jenis Pertanyaan</label>
            <select name="question_type" class="form-control" id="question_type" required>
                <option value="text" {{ $question->question_type == 'text' ? 'selected' : '' }}>Teks</option>
                <option value="select" {{ $question->question_type == 'select' ? 'selected' : '' }}>Select</option>
                <option value="checkbox" {{ $question->question_type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                <option value="radio" {{ $question->question_type == 'radio' ? 'selected' : '' }}>Radio</option>
            </select>
        </div>

        <div id="options-container" class="form-group" style="display: {{ in_array($question->question_type, ['select', 'checkbox', 'radio']) ? 'block' : 'none' }}">
            <label>Opsi Jawaban</label>
            <button type="button" class="btn btn-secondary" onclick="addOption()">Tambah Opsi</button>
            @foreach($question->options as $option)
                <div class="form-group">
                    <input type="text" name="options[]" class="form-control mt-2" value="{{ $option->option_text }}">
                </div>
            @endforeach
            <div id="option-template" class="form-group mt-2" style="display: none;">
                <input type="text" name="options[]" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <script>
        document.getElementById('question_type').addEventListener('change', function () {
            var optionsContainer = document.getElementById('options-container');
            if (['select', 'checkbox', 'radio'].includes(this.value)) {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
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
    </script>
@endsection
