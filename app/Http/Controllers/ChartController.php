<?php

namespace App\Http\Controllers;

use App\Models\answer;
use App\Models\Details;
use Illuminate\Http\Request;
use App\Models\form;
use App\Models\Question;
use App\Models\section;
use App\models\pillar;

class ChartController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index() {}

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
  public function avg($form_id, $user_id, $details_id)
  {
    $user_id =  auth()->user()->id;
    $user = auth()->user();

    $pillars = Section::with('pillar')->where('form_id', $form_id)->get();
    $detail = Details::find($details_id); // Retrieve single instance

    if ($detail) {
      $submission_id = $detail->submission_id;
      $print_section = Section::where('form_id', $detail->form_id)->get();
      $print_question = Question::where('form_id', $detail->form_id)->get();
      $print_answers = Answer::where('form_id',$detail->form_id)->where('submission_id',$submission_id)->get();
      // dd($print_answers);
      $comment = $detail->comment;
      $company = $user->company;
      $name = $user->name;
      $company_details = $detail->company;
      $located = $detail->located;
      $Primary = $detail->Primary;
      $business_goals = $detail->business_goals;
      $drivers = $detail->drivers;
      $tools = $detail->tools;
      // dd($drivers);

    }
    $pillarData = [];
    $radarLabels = [];
    $radarSeriesData = [];
    $questionAverages = [];

    foreach ($pillars->groupBy('pillar_id') as $pillarId => $sections) {
      $pillarName = $sections->first()->pillar->name ?? 'Unknown Pillar';
      $sectionScores = [];

      foreach ($sections as $section) {
        $questions = Question::where('form_id', $form_id)->where('section_id', $section->id)->get();
        $totalScore = 0;
        $count = 0;

        foreach ($questions as $question) {
          $options = json_decode($question->options);
          $answers = Answer::where('question_id', $question->id)
            ->where('submission_id', $submission_id)
            ->get();

          foreach ($answers as $answer) {
            if (is_array($options)) {
              $selectedIndex = array_search($answer->answer, $options);
              if ($selectedIndex !== false) {
                $percentage = ($selectedIndex + 1) * 20;
                $totalScore += $percentage;
                $count++;
              }
            }
          }
        }

        if ($count > 0) {
          $averageScore = $totalScore / $count;
          $sectionScores[] = round($averageScore, 2);
        }
      }
      if (!empty($sectionScores)) {
        $pillarData[$pillarId] = [
          'pillar_name' => $pillarName,
          'total_sections' => count($sections),
          'sections' => $sectionScores,
        ];
      }
    }

    $StackedLabels = [];
    $StackedData = [];

    $sectionNames = [];

    foreach ($pillarData as $pillarId => $pillar) {
      $totalPillarScore = 0;
      $totalQuestionCount = 0;

      foreach ($pillar['sections'] as $sectionIndex => $sectionScore) {
        $section = $pillars->where('pillar_id', $pillarId)->skip($sectionIndex)->first();
        if ($section) {
          // Count the actual number of questions in this section
          $questionCount = Question::where('form_id', $form_id)
            ->where('section_id', $section->id)
            ->count();

          if ($questionCount > 0) { // Avoid division by zero
            $totalPillarScore += $sectionScore * $questionCount; // Weight section score by question count
            $totalQuestionCount += $questionCount;
          }
        }
      }

      $radarLabels[] = $pillar['pillar_name'];
      $radarSeriesData[] = ($totalQuestionCount > 0) ? round($totalPillarScore / $totalQuestionCount, 2) : 0;
    }

    foreach ($pillarData as $pillarId => $pillar) {
      $StackedLabels[] = $pillar['pillar_name']; // Add pillar name

      foreach ($pillar['sections'] as $index => $average) {
        // Ensure there's a column for each section in each pillar
        if (!isset($StackedData[$index])) {
          $StackedData[$index] = [];
        }

        $StackedData[$index][] = $average; // Store section averages

        // Collect section names
        if (!isset($sectionNames[$index])) {
          $sectionNames[$index] = "Section " . ($index + 1);
        }
      }
    }

    $pillarDatas = [];
    // Iterate through the sections grouped by pillar_id
    foreach ($pillars->groupBy('pillar_id') as $pillarId => $sectionsInPillar) {
      $pillarName = Pillar::find($pillarId)->name ?? 'Unknown Pillar';
      $questionAverages = [];

      // Loop through the sections under this pillar
      foreach ($sectionsInPillar as $section) {
        // Get questions for this section
        $questions = Question::where('form_id', $form_id)->where('section_id', $section->id)->get();

        // Loop through each question to calculate averages
        foreach ($questions as $question) {
          $answers = Answer::where('question_id', $question->id)
            ->where('submission_id', $submission_id) // Filter by submission_id
            ->get();
          $totalScore = 0;
          $count = 0;

          foreach ($answers as $answer) {
            $options = json_decode($question->options);
            if (is_array($options)) {
              $selectedIndex = array_search($answer->answer, $options);
              if ($selectedIndex !== false) {
                $percentage = ($selectedIndex + 1) * 20;
                $totalScore += $percentage;
                $count++;
              }
            }
          }

          // Calculate and store average score for this question
          if ($count > 0) {
            $averageScore = $totalScore / $count;
            $questionAverages[] = [
              'question_text' => $question->question_text,
              'average_score' => round($averageScore, 2)
            ];
          }
        }
      }

      // Store the data for this pillar if it has questions
      if (!empty($questionAverages)) {
        $pillarDatas[] = [
          'pillar_name' => $pillarName,
          'questions' => $questionAverages
        ];
      }
    }

    // Debugging output to verify all pillars and their questions
    // dd($pillarDatas);


    $questionLabels = [];
    $questionData = [];
    foreach ($pillarDatas as $pillar) {
      foreach ($pillar['questions'] as $question) {
        $questionLabels[] = $question['question_text'];
        $questionData[] = $question['average_score'];
      }
    }
    // dd($questionData);

    $sections = Section::where('form_id', $form_id)->get();
    $averageData = [];
    $totalSectionScore = 0;
    $validSectionsCount = 0;

    foreach ($sections as $section) {
      $questions = Question::where('form_id', $form_id)
        ->where('section_id', $section->id)
        ->get();
      $totalScore = 0;
      $totalCount = 0;
      $count = 0;

      // Loop through each question in the section
      foreach ($questions as $question) {
        $options = json_decode($question->options);
        // Find answers for this question
        $answers = Answer::where('question_id', $question->id)
          ->where('submission_id', $submission_id) // Filter by submission_id
          ->get();

        // Loop through each answer for the question
        foreach ($answers as $answer) {
          if (is_array($options)) {
            // Find the index of the selected answer in options
            $selectedIndex = array_search($answer->answer, $options);
            if ($selectedIndex !== false) {
              // Calculate percentage based on selected index (Assuming options are indexed from 0)
              $percentage = ($selectedIndex + 1) * 20;
              $totalScore += $percentage; // Accumulate score
              $count++;
            }
          }
        }
      }

      // Calculate average for this section if there are valid answers
      if ($count > 0) {
        $averageScore = ($totalScore / $count); // Average score per section
        $averageData[$section->id] = [
          'section_name' => $section->section_name,
          'average_score' => round($averageScore, 2) // Round off to two decimal places
        ];
        $totalSectionScore += $averageScore;
        $validSectionsCount++;
      }
    }
    $overallAverage = $validSectionsCount > 0 ? round($totalSectionScore / $validSectionsCount, 2) : 0;

    // dd($averageData, $overallAverage);


    // dd($averageData);
    $chartLabels = array_column($averageData, 'section_name');
    $chartData = array_column($averageData, 'average_score');
    $chartLabel[] = 'Overall Average';
    $chartDatas[] = $overallAverage;
    // Logic for creating section data
    // Logic for creating section data
    $sections = Section::where('form_id', $detail->form_id)->get()->keyBy('id');
    $questions = Question::where('form_id', $detail->form_id)->with('section')->get();

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


      $answers = Answer::where('question_id', $question->id)
        ->where('submission_id', $submission_id)
        ->get();

      // Find the answer for this question
      $answer = $answers->first(); // Since each question has one answer per submission

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
    // dd($sectionData);
    return view('panel.chart.index', compact(
      'chartLabels',
      'chartData',
      'sectionData',
      'chartDatas',
      'chartLabel',
      'radarLabels',
      'radarSeriesData',
      'pillarDatas',
      'StackedLabels',
      'StackedData',
      'sections',
      'questions',
      'answers','print_section','print_question','print_answers','comment','name','company',
      'company_details','located','Primary','business_goals','drivers','detail','tools'
    ));
  }

  // public function demo()
  // {
  //   $user_id =  auth()->user()->id;
  //   $pillar = pillar::pluck('id')->first();
  //   // dd($pillar);
  //   // $pillars = Section::with('pillar')->where('form_id', $form_id)->get();
  //   // $detail = Details::find($details_id);
  //   return view('panel.chart.index',compact('pillar'));
  // }
}
