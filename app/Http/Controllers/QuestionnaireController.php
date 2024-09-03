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
    // Menampilkan daftar pertanyaan
    public function index()
    {
        $questions = Question::all();
        return view('applications.mbkm.questionnaire.questions.index', compact('questions'));
    }

    // Menampilkan form untuk membuat pertanyaan baru
    public function createQuestion()
    {
        return view('applications.mbkm.questionnaire.questions.create');
    }

    // Menyimpan pertanyaan baru ke database
    public function storeQuestion(Request $request)
    {
        // Jika tipe pertanyaan adalah 'text', lakukan validasi tanpa 'options'
        if ($request->question_type == 'text') {
            $request->validate([
                'question_text' => 'required|string|max:255',
                'question_type' => 'required|in:text,select,checkbox,radio',
            ]);
        } else {
            // Filter opsi yang kosong jika tipe bukan 'text'
            $filteredOptions = array_filter($request->options ?? [], function ($option) {
                return !is_null($option) && $option !== '';
            });

            $request->merge(['options' => $filteredOptions]);

            // Validasi jika tipe bukan 'text'
            $request->validate([
                'question_text' => 'required|string|max:255',
                'question_type' => 'required|in:text,select,checkbox,radio',
                'options' => 'required_if:question_type,select,checkbox,radio|array|min:1',
                'options.*' => 'required_if:question_type,select,checkbox,radio|string|max:255',
            ]);
        }

        // Buat pertanyaan
        $question = Question::create($request->only('question_text', 'question_type'));

        // Simpan opsi jika ada dan tipe pertanyaan bukan 'text'
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

    // Menampilkan form untuk mengedit pertanyaan
    public function editQuestion(Question $question)
    {
        return view('applications.mbkm.questionnaire.questions.edit', compact('question'));
    }

    // Mengupdate pertanyaan yang ada
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

    // Menghapus pertanyaan
    public function destroyQuestion(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Pertanyaan berhasil dihapus!');
    }

    // Menampilkan form kuesioner untuk peserta tertentu
    public function create($peserta_id)
    {
        $peserta = Peserta::findOrFail($peserta_id);
        $questions = Question::with('options')->get();
        return view('applications.mbkm.questionnaire.create', compact('peserta', 'questions'));
    }

    // Menyimpan jawaban kuesioner
    // Menyimpan jawaban kuesioner
    public function store(Request $request, $peserta_id)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required', // Menghapus validasi string untuk memungkinkan array
        ]);

        $response = Response::create(['peserta_id' => $peserta_id]);

        foreach ($request->answers as $question_id => $answer) {
            // Periksa apakah jawabannya berupa array (checkbox)
            if (is_array($answer)) {
                $answer = implode(', ', $answer); // Gabungkan jawaban menjadi string
            }

            ResponseDetail::create([
                'response_id' => $response->id,
                'question_id' => $question_id,
                'answer' => $answer,
            ]);
        }

        return redirect()->route('questionnaire.thankyou');
    }

    // Menampilkan halaman terima kasih setelah pengisian kuesioner
    public function thankyou()
    {
        return view('applications.mbkm.questionnaire.thankyou');
    }
}
