<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Questionnaire\Option;
use App\Models\Questionnaire\Question;
use App\Models\Questionnaire\Response;
use App\Models\Questionnaire\ResponseDetail;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('applications.mbkm.questionnaire.questions.index', compact('questions'));
    }

    public function createQuestion()
    {
        return view('applications.mbkm.questionnaire.questions.create');
    }

    public function storeQuestion(Request $request)
    {
        if ($request->question_type == 'text') {
            $request->validate([
                'question_text' => 'required|string|max:255',
                'question_type' => 'required|in:text,select,checkbox,radio',
            ]);
        } else {
            $filteredOptions = array_filter($request->options ?? [], function ($option) {
                return !is_null($option) && $option !== '';
            });

            $request->merge(['options' => $filteredOptions]);

            $request->validate([
                'question_text' => 'required|string|max:255',
                'question_type' => 'required|in:text,select,checkbox,radio',
                'options' => 'required_if:question_type,select,checkbox,radio|array|min:1',
                'options.*' => 'required_if:question_type,select,checkbox,radio|string|max:255',
            ]);
        }

        $question = Question::create($request->only('question_text', 'question_type'));

        if ($request->question_type !== 'text' && !empty($filteredOptions)) {
            foreach ($filteredOptions as $option) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $option,
                ]);
            }
        }

        return redirect()->route('questions.index')->with('success', 'Pertanyaan dan opsi jawaban berhasil ditambahkan!');
    }

    public function editQuestion(Question $question)
    {
        return view('applications.mbkm.questionnaire.questions.edit', compact('question'));
    }

    public function updateQuestion(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string|max:255',
            'question_type' => 'required|in:text,select,checkbox,radio',
            'options' => 'required_if:question_type,select,checkbox,radio|array|min:1',
            'options.*' => 'required_if:question_type,select,checkbox,radio|string|max:255',
        ]);

        $question->update($request->only('question_text', 'question_type'));

        $question->options()->delete();

        if (in_array($request->question_type, ['select', 'checkbox', 'radio'])) {
            foreach ($request->options as $option) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $option,
                ]);
            }
        }

        return redirect()->route('questions.index')->with('success', 'Pertanyaan dan opsi jawaban berhasil diperbarui!');
    }

    public function destroyQuestion(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Pertanyaan berhasil dihapus!');
    }

    public function create($peserta_id)
    {
        $peserta = Peserta::findOrFail($peserta_id);
        $questions = Question::with('options')->get();
        session(['peserta_id' => $peserta_id]);
        return view('applications.mbkm.questionnaire.create', compact('peserta', 'questions'));
    }

    public function store(Request $request, $peserta_id)
    {
        if (session('peserta_id') != $peserta_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required',
        ]);

        $response = Response::create(['peserta_id' => $peserta_id]);

        foreach ($request->answers as $question_id => $answer) {
            if (is_array($answer)) {
                $answer = implode(', ', $answer);
            }

            ResponseDetail::create([
                'response_id' => $response->id,
                'question_id' => $question_id,
                'answer' => $answer,
            ]);
        }

        return redirect()->route('questionnaire.thankyou');
    }

    public function thankyou()
    {
        return view('applications.mbkm.questionnaire.thankyou');
    }
}
