@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('questionnaire.store', ['peserta_id' => $peserta->id]) }}">
    @csrf
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Form Evaluasi MBKM untuk Peserta: {{ $peserta->nama }}</h5>
            </div>
            <div class="card-body">
                @foreach ($questions as $question)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">{{ $question->question_text }}</label>
                            @if ($question->question_type == 'text')
                                <input type="text" class="form-control" name="answers[{{ $question->id }}]" required>
                            @elseif ($question->question_type == 'select')
                                <select class="form-select" name="answers[{{ $question->id }}]" required>
                                    <option value="" disabled selected>Pilih salah satu</option>
                                    @foreach ($question->options as $option)
                                        <option value="{{ $option->option_text }}">{{ $option->option_text }}</option>
                                    @endforeach
                                </select>
                            @elseif ($question->question_type == 'radio')
                                @foreach ($question->options as $option)
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="answers[{{ $question->id }}]" value="{{ $option->option_text }}" id="option-{{ $option->id }}" required>
                                        <label for="option-{{ $option->id }}" class="form-check-label">{{ $option->option_text }}</label>
                                    </div>
                                @endforeach
                            @elseif ($question->question_type == 'checkbox')
                                @foreach ($question->options as $option)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="answers[{{ $question->id }}][]" value="{{ $option->option_text }}" id="checkbox-{{ $option->id }}">
                                        <label for="checkbox-{{ $option->id }}" class="form-check-label">{{ $option->option_text }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Kirim</button>
</form>
@endsection
