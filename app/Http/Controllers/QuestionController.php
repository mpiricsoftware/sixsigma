<?php

namespace App\Http\Controllers;

use App\Models\answer;
use App\Models\section;
use App\Models\Question;
use App\Models\User;
use App\Models\form;
use Illuminate\Http\Request;
use App\Models\Details;

class QuestionController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    // $sections = section::all();
    // return view('panel.question.show', compact('sections'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    // Fetch the current section by its ID

  }
  public function define($sectionId)
{
    $sections = Section::all();
    $questions = Question::all();
     // or a filtered query depending on your need
    // $questions = Question::where('section_id', $sectionId)->get();
    // $nextSection = Section::where('id', '>', $sectionId)->first();

    return view('panel.question.show', compact('sections', 'questions'));
}


  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
{
    // // Find the question by id (or get a specific set of questions)
    // $question = Question::findOrFail($id);

    // // You may also want to load other related data, like sections
    // $sections = Section::all();  // Assuming you need to pass all sections

    // return view('panel.question.view', compact('question', 'sections'));
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
  public function home(Request $request,$slug)
  {
// dd('hi');
     $form = Form::where('slug', $slug)->firstOrFail();
    // dd($form);
    $sections = Section::where('form_id',$form->id)->get();
    // dd($sections);
    $questions = Question::where('form_id',$form->id)->get();
    $totalQuestions = Question::where('form_id', $form->id)->count();

    return view('panel.question.show',compact('questions','sections','form','totalQuestions'));
  }

  public function print($id, $user_id)
  {
      $user_id = auth()->user()->id;
      $form = Form::findOrFail($id);
      $sections = Section::where('form_id', $id)->get();
      $questions = Question::where('form_id', $id)->get();
      $latestSubmission = Answer::where('form_id', $id)
          ->where('user_id', $user_id)
          ->orderBy('created_at', 'desc')
          ->first();
      $answers = Answer::where('submission_id', $latestSubmission->submission_id)
          ->orderBy('created_at', 'desc')
          ->get();
      $submissionId = $latestSubmission ? $latestSubmission->submission_id : null;
      return view('panel.question.print', compact('sections', 'questions', 'answers', 'user_id', 'submissionId'));
  }

  public function dprint($id)
  {
      $detail = Details::find($id);

      if ($detail) {
        $sections = Section::where('form_id', $detail->form_id)->get();
        $questions = Question::where('form_id', $detail->form_id)->get();
          //  dd($questions);
          $answers = Answer::where('submission_id', $detail->submission_id)
          ->where('form_id',$detail->form_id)->get();

          // $chartRoute = route('avg', ['form_id' => $detail->form_id, 'user_id' => $detail->user_id]);
      } else {
          echo "No detail found with the provided id.";
      }
      return view('panel.question.print', compact('answers','sections','questions'));
  }




}
