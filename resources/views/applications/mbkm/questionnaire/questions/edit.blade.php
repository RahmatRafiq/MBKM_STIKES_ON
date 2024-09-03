@extends('layouts.app')

@section('title', 'Edit Pertanyaan')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Pertanyaan</h5>
            <a href="{{ route('questions.index') }}" class="btn btn-secondary">Back</a>
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

            <form action="{{ route('questions.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="question_text" class="form-label">Pertanyaan</label>
                    <input type="text" name="question_text" class="form-control" id="question_text" value="{{ $question->question_text }}" required>
                </div>

                <div class="mb-3">
                    <label for="question_type" class="form-label">Jenis Pertanyaan</label>
                    <select name="question_type" class="form-select" id="question_type" required>
                        <option value="text" {{ $question->question_type == 'text' ? 'selected' : '' }}>Teks</option>
                        <option value="select" {{ $question->question_type == 'select' ? 'selected' : '' }}>Select</option>
                        <option value="checkbox" {{ $question->question_type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                        <option value="radio" {{ $question->question_type == 'radio' ? 'selected' : '' }}>Radio</option>
                    </select>
                </div>

                <div id="options-container" class="mb-3" style="display: {{ in_array($question->question_type, ['select', 'checkbox', 'radio']) ? 'block' : 'none' }}">
                    <label class="form-label">Opsi Jawaban</label>
                    <button type="button" class="btn btn-secondary mb-2" onclick="addOption()">Tambah Opsi</button>
                    @foreach($question->options as $option)
                        <div class="mb-2">
                            <input type="text" name="options[]" class="form-control" value="{{ $option->option_text }}">
                        </div>
                    @endforeach
                    <div id="option-template" class="mb-2" style="display: none;">
                        <input type="text" name="options[]" class="form-control">
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
