<?php

namespace App\Http\Controllers;

use App\Models\answer;
use App\Models\section;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\form;
use App\Models\Details;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $section = Section::all();
    $question = Question::all();
    // dd($question);
    return view('panel.answer.index', compact('section', 'question'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
{
    $answers = $request->input('answers');
    $questionIds = $request->input('question_ids');
    $user = auth()->user();
    $form = null;

    // Generate unique submission ID for each form submission
    $submissionId = now()->timestamp . '-' . $user->id;

    foreach ($answers as $sectionId => $questions) {
        foreach ($questions as $index => $answer) {
            $questionId = $questionIds[$sectionId][$index] ?? null;
            if (!$questionId) continue;

            $question = Question::where('id', $questionId)->where('section_id', $sectionId)->first();
            if (!$question) continue;

            $form = $question->form_id;
            $answers_future = $request->answers_future[$sectionId][$index] ?? null;
            // dd($answers_future);
            $answersd = Answer::create([
                'section_id' => $sectionId,
                'question_id' => $questionId,
                'user_id' => $user->id,
                'submission_id' => $submissionId,
                'form_id' => $form,
                'answer' => is_array($answer) ? json_encode($answer) : $answer,
                'answers_future' => $answers_future,

            ]);
        }
    }
// dd($request->all());
    // Store submission details
    // if ($form) {
    //     $detais  = Details::create([
    //         'user_id' => $user->id,
    //         'form_id' => $form,
    //         'submission_id' => $submissionId,

    //     ]);
    // }

    return view("panel.question.view", compact('form', 'user'));
}




  /**
   * Display the specified resource.
   */
  public function show(string $id) {

  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
  // QuestionController.php
  public function getQuestions($sectionId)
  {
    // Fetch questions for the selected section
    $questions = Question::where('section_id', $sectionId)->get();

    // Return the questions as JSON
    return response()->json(['questions' => $questions]);
  }
}
