<?php

namespace App\Http\Controllers;

use App\Models\section;
use App\Models\Question;

use Illuminate\Http\Request;

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
    $questions = Question::all(); // or a filtered query depending on your need
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
  public function home()
  {
    $sections = Section::all();
    $questions = Question::all();
    return view('panel.question.show',compact('questions','sections'));
  }
}
