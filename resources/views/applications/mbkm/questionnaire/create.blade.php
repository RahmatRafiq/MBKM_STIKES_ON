@extends('layouts.app')

@section('title', 'Form Evaluasi MBKM')

@section('content')
    <h1>Form Evaluasi MBKM untuk Peserta: {{ $peserta->nama }}</h1>
    <form action="{{ route('questionnaire.store', ['peserta_id' => $peserta->id]) }}" method="POST">
        @csrf
        @foreach ($questions as $question)
            <label>{{ $question->question_text }}</label><br>
            @if ($question->question_type == 'text')
                <input type="text" name="answers[{{ $question->id }}]" required><br><br>
            @elseif ($question->question_type == 'select')
                <select name="answers[{{ $question->id }}]" required>
                    @foreach ($question->options as $option)
                        <option value="{{ $option->option_text }}">{{ $option->option_text }}</option>
                    @endforeach
                </select><br><br>
            @elseif ($question->question_type == 'radio')
                @foreach ($question->options as $option)
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->option_text }}" required>{{ $option->option_text }}<br>
                @endforeach
            @elseif ($question->question_type == 'checkbox')
                @foreach ($question->options as $option)
                    <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->option_text }}">{{ $option->option_text }}<br>
                @endforeach
            @endif
        @endforeach
        <button type="submit">Kirim</button>
    </form>
@endsection
