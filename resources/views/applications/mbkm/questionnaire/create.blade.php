@extends('layouts.app')

@section('title', 'Form Evaluasi MBKM')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Form Evaluasi MBKM untuk Peserta: {{ $peserta->nama }}</h1>
        <form action="{{ route('questionnaire.store', ['peserta_id' => $peserta->id]) }}" method="POST">
            @csrf
            @foreach ($questions as $question)
                <div class="mb-3">
                    <label class="form-label">{{ $question->question_text }}</label>
                    @if ($question->question_type == 'text')
                        <input type="text" name="answers[{{ $question->id }}]" class="form-control" required>
                    @elseif ($question->question_type == 'select')
                        <select name="answers[{{ $question->id }}]" class="form-select" required>
                            @foreach ($question->options as $option)
                                <option value="{{ $option->option_text }}">{{ $option->option_text }}</option>
                            @endforeach
                        </select>
                    @elseif ($question->question_type == 'radio')
                        @foreach ($question->options as $option)
                            <div class="form-check">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->option_text }}" class="form-check-input" required>
                                <label class="form-check-label">{{ $option->option_text }}</label>
                            </div>
                        @endforeach
                    @elseif ($question->question_type == 'checkbox')
                        @foreach ($question->options as $option)
                            <div class="form-check">
                                <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->option_text }}" class="form-check-input">
                                <label class="form-check-label">{{ $option->option_text }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
    </div>
@endsection
