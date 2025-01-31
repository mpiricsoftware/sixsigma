<?php

namespace App\Http\Controllers;

use App\Models\answer;
use Illuminate\Http\Request;
use App\Models\form;
use App\Models\Question;
use App\Models\section;

class ChartController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $form = form::all();
    // dd($form);
    $labels = [];
    $data = [];
    foreach ($form as $f) {
      $labels[] = $f->name;
      $data[] = $f->slug;
    }
    return view('panel.chart.index', compact('labels', 'data'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $form_id = 77;

    // Retrieve all sections related to the form and key them by their ID
    $sections = Section::where('form_id', $form_id)->get()->keyBy('id'); // Key by section ID for easy access

    // Retrieve all questions with their sections
    $questions = Question::where('form_id', $form_id)->with('section')->get();
    // Retrieve all answers for the form
    $answers = Answer::where('form_id', $form_id)->get();

    // Initialize data structure for sections
    $sectionData = []; // Array to hold data for each section

    foreach ($questions as $question) {
      // Check if the section exists in the sections array
      if (!isset($sectionData[$question->section_id])) {
        // Use isset to check if the section exists before accessing its name
        if (isset($sections[$question->section_id])) {
          $sectionData[$question->section_id] = [
            'name' => $sections[$question->section_id]->section_name,
            'labels' => [], // To hold question texts
            'percentages' => [] // To hold calculated percentages
          ];
        } else {
          // Handle case where the section does not exist
          $sectionData[$question->section_id] = [
            'name' => 'Unknown Section', // Default name if section is missing
            'labels' => [],
            'percentages' => []
          ];
        }
      }

      // Store question text
      $sectionData[$question->section_id]['labels'][] = $question->question_text;

      // Decode options for the question
      $options = json_decode($question->options);
      // Find the answer for this question
      $answer = $answers->where('question_id', $question->id)->first();

      if ($answer && is_array($options)) {
        // Find the index of the selected answer in options
        $selectedIndex = array_search($answer->answer, $options);

        if ($selectedIndex !== false) {
          // Calculate the score based on the selected answer index
          // The score is determined by the position of the selected option
          // Map selected index to level percentage
          $percentage = ($selectedIndex + 1) * 20; // Assuming options are indexed from 0
          $sectionData[$question->section_id]['percentages'][] = $percentage; // Store percentage for this question
        } else {
          // If no valid answer is found, default to 0%
          $sectionData[$question->section_id]['percentages'][] = 0;
        }
      } else {
        // If no answer exists, default to 0%
        $sectionData[$question->section_id]['percentages'][] = 0;
      }
    }

    return view('panel.chart.section', compact('sectionData')); // Pass section data to the view
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
  public function show(string $id)
  {
    //
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
  public function avg($form_id)
  {
    $sections = Section::where('form_id', $form_id)->get();
    $averageData = [];

    foreach ($sections as $section) {
      $questions = Question::where('form_id', $form_id)
        ->where('section_id', $section->id)
        ->get();
      $totalScore = 0;
      $count = 0;

      foreach ($questions as $question) {
        $options = json_decode($question->options);
        // Find answers for this question
        $answers = Answer::where('question_id', $question->id)->get();

        foreach ($answers as $answer) {
          if (is_array($options)) {
            // Find the index of the selected answer in options
            $selectedIndex = array_search($answer->answer, $options);
            if ($selectedIndex !== false) {
              // Calculate percentage based on selected index
              $percentage = ($selectedIndex + 1) * 20; // Assuming options are indexed from 0
              $totalScore += $percentage; // Accumulate score
              $count++; // Count valid answers
            }
          }
        }
      }
// dd($selectedIndex);
      // Calculate average for this section if there are valid answers
      if ($count > 0) {
        $averageScore = ($totalScore / ($count * 100)) * 100; // Normalize to percentage out of 100
        $averageData[$section->id] = [
          'section_name' => $section->section_name,
          'average_score' => round($averageScore, 2) // Round off to two decimal places
        ];
      }
    }
    // dd($averageScore);
    // Prepare data for charting averages
    $chartLabels = array_column($averageData, 'section_name');
    $chartData = array_column($averageData, 'average_score');

    // Logic for creating section data
    $sections = Section::where('form_id', $form_id)->get()->keyBy('id');
    $questions = Question::where('form_id', $form_id)->with('section')->get();
    $answers = Answer::where('form_id', $form_id)->get();

    // Initialize data structure for sections
    $sectionData = [];

    foreach ($questions as $question) {
      if (!isset($sectionData[$question->section_id])) {
        if (isset($sections[$question->section_id])) {
          $sectionData[$question->section_id] = [
            'name' => $sections[$question->section_id]->section_name,
            'description' => $sections[$question->section_id]->section_description,
            'labels' => [],
            'percentages' => []
          ];
        } else {
          $sectionData[$question->section_id] = [
            'name' => 'Unknown Section',
            'labels' => [],
            'percentages' => []
          ];
        }
      }

      // Store question text
      $sectionData[$question->section_id]['labels'][] = $question->question_text;

      // Decode options for the question
      $options = json_decode($question->options);
      // Find the answer for this question
      $answer = $answers->where('question_id', $question->id)->first();

      if ($answer && is_array($options)) {
        // Find the index of the selected answer in options
        $selectedIndex = array_search($answer->answer, $options);

        if ($selectedIndex !== false) {
          // Calculate the score based on the selected answer index
          $percentage = ($selectedIndex + 1) * 20;
          $sectionData[$question->section_id]['percentages'][] = $percentage;
        } else {
          $sectionData[$question->section_id]['percentages'][] = 0;
        }
      } else {
        $sectionData[$question->section_id]['percentages'][] = 0;
      }
    }

    return view('panel.chart.avg', compact('chartLabels', 'chartData', 'sectionData'));
  }
}
