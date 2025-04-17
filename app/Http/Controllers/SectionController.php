<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\section;
use App\Models\form;
use App\Models\Question;
use App\Models\pillar;
class SectionController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      // Retrieve AJAX request data
      $search = $request->input('search.value');
      $start = (int) $request->input('start', 0);
      $length = (int) $request->input('length', 10);
      $draw = (int) $request->input('draw', 1);

      // Query builder for fetching inputs
      $query = section::query();

      // Apply search filters if search term exists
      if ($search) {
        $query->where(function ($q) use ($search) {
          $q->where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%");
        });
      }

      // Get total data count without any filters
      $totalData = section::count();

      // Get the count of filtered data based on search
      $filteredData = $query->count();

      // Retrieve the filtered results with pagination
      $forms = $query->offset($start)
        ->limit($length)
        ->get();

      // Map the results into the desired format for DataTables
      $data = $forms->map(function ($form) {
        return [
          'id' => $form->id,
          'name' => $form->name,

        ];
      });

      // Return the response in DataTable format
      return response()->json([
        'draw' => $draw,
        'recordsTotal' => $totalData,
        'recordsFiltered' => $filteredData,
        'data' => $data,
      ]);
    }
    return view('panel.form.index');
  }
  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('panel.form.show');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // dd($request->all());
    $user_id =  auth()->user()->id;

    $request->validate([
      'pillar_id.*' => 'required|exists:pillar,id',
      'section_name.*' => 'required|string|max:255',
      'section_description.*' => 'nullable|string|max:10000',
      'question_text.*' => 'nullable|array',
      'question_text.*.*' => 'nullable|string|max:255',
      'question_description.*' => 'nullable|array',
      'question_description.*.*' => 'nullable|string|max:5000',
      'type.*' => 'required|array',
      'type.*.*' => 'required|string',
      'options.*' => 'nullable|array',
    ]);
    $form = $request->all();
    // dd($form);
    $createdSections = [];
    $i = 1;
    $orderNo = 1;
    if (is_array($request->section_name) && is_array($request->section_description)) {
      foreach ($request->section_name as $key => $sectionName) {
        // dd($request->all(),$request->question_text[$i] );
        $sectionDescription = $request->section_description[$key] ?? null;
        $pillarId = $request->pillar_id[$key] ?? null;
        $section = Section::create([
          'form_id' => $form['id'],
          'section_name' => $sectionName,
          'section_description' => $sectionDescription,
          'pillar_id' => $pillarId,
          'order_no' => $orderNo // Add the order number
        ]);
        
        $orderNo++; 

// dd($section);
        if (isset($request->question_text[$i]) && is_array($request->question_text[$i])) {
          foreach ($request->question_text[$i] as $key => $questionText) {
            $description = $request->question_description[$i][$key] ?? null;
            $type = $request->type[$i][$key] ?? null;
            $choiceOptions = $request->options["choice_{$i}_{$key}"] ?? [];
            $ratingOptions = $request->options["rating_{$i}"] ?? [];

            // Determine options based on question type
            $options = null;
            if ($type === 'radio' || $type === 'checkbox') {
                $options = !empty($choiceOptions) ? json_encode($choiceOptions) : null;
            } elseif ($type === 'rating') {
                $options = !empty($ratingOptions) ? json_encode($ratingOptions) : null;
            }
            if ($questionText) {
              $question = Question::create([
                'section_id' => $section->id,
                'form_id' => $form['id'],
                'question_text' => $questionText,
                'question_description' => $description,
                'type' => $type,
                'options' => $options,
              ]);
              $createdQuestions[] = $question;
            }
          }
        }
        $i++;
      }
      // dd($request->all());
    }


    // dd($request->all(), $createdSections, $createdQuestions);
    return redirect()->route('form-list.index')->with('success', 'Sections and questions created successfully!');
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

   public function updateNew(Request $request)
{
    // dd($request->all());
    $request->validate([
        'pillar_id.*' => 'required|exists:pillar,id',
        'section_id.*' => 'nullable|integer|exists:section,id',
        'section_name.*' => 'required|string|max:255',
        'section_description.*' => 'nullable|string|max:10000',
        'question_id.*' => 'nullable|array',
        'question_id.*.*' => 'nullable|integer|exists:question,id',
        'question_text.*' => 'nullable|array',
        'question_text.*.*' => 'nullable|string|max:255',
        'question_description.*' => 'nullable|array',
        'question_description.*.*' => 'nullable|string|max:5000',
        'type.*' => 'nullable|array',
        'type.*.*' => 'required|string',
        'options.*' => 'nullable|array',
        'option_text.*.*.*' => 'nullable|string',
    ]);

    $formId = $request->id;

    // Loop through each section
    foreach ($request->section_name as $sectionIndex => $sectionName) {
        $sectionId = $request->section_id[$sectionIndex] ?? null;
        $sectionDescription = $request->section_description[$sectionIndex] ?? null;
        $pillarId = $request->pillar_id[$sectionIndex] ?? null;
        // dd($pillarId);
        if ($sectionId) {
            $section = Section::find($sectionId);
            if ($section) {
                $section->update([
                    'form_id' => $formId,
                    'section_name' => $sectionName,
                    'section_description' => $sectionDescription,
                    'pillar_id' => $pillarId
                ]
              );
            }
            // dd($section);
        } else {
            $newsection = Section::create([
                'form_id' => $formId,
                'section_name' => $sectionName,
                'section_description' => $sectionDescription,
                'pillar_id' => $pillarId
            ]);
            $sectionId = $newsection->id;
        }
        if (isset($request->question_text[$sectionId]) && is_array($request->question_text[$sectionId])) {
            foreach ($request->question_text[$sectionId] as $questionIndex => $questionText) {
                $questionId = $request->question_id[$sectionId][$questionIndex] ?? null;
                $description = $request->question_description[$sectionId][$questionIndex] ?? null;
                $type = $request->type[$sectionId][$questionIndex] ?? null;

                $options = null;
                if ($type === 'radio' || $type === 'checkbox') {
                    $options = json_encode($request->options["choice_{$sectionId}_{$questionIndex}"] ?? []);
                } elseif ($type === 'rating') {
                    $options = json_encode($request->options["rating_{$sectionId}"] ?? []);
                }

                $options_text = null;
                if ($type === 'radio' || $type === 'checkbox') {
                  if (isset($request->option_text[$sectionId][$questionIndex]) && 
                        is_array($request->option_text[$sectionId][$questionIndex])) {
                        // Filter out any empty option values
                        $optionValues = array_filter(
                            $request->option_text[$sectionId][$questionIndex], 
                            function($value) { return !empty(trim($value)); }
                        );
                        
                        // Convert options to JSON
                        $options_text = json_encode(array_values($optionValues));
                    }
                } elseif ($type === 'rating') {
                    // Handle rating options if needed
                    $options_text = json_encode([1, 2, 3, 4, 5]); // Default rating options
                }

                if ($questionId) {
                    $question = Question::find($questionId);
                    if ($question) {
                        $question->update([
                            'section_id' => $sectionId,
                            'form_id' => $formId,
                            'question_text' => $questionText,
                            'question_description' => $description,
                            'type' => $type,
                            'options' => $options_text,
                          ],
                        //     [
                        //     'options' => $options,

                        // ]
                      );
                    }

                } else {
                    Question::create([
                        'section_id' => $sectionId,
                        'form_id' => $formId,
                        'question_text' => $questionText,
                        'question_description' => $description,
                        'type' => $type,


                        'options' => $options,
                    ]);
                }
            }
        }
    }
// dd($request->all());
    return redirect()->route('form-list.index')->with('success', 'Sections and questions updated successfully!');
}







  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
