<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\section;
use App\Models\form;
use App\Models\Question;

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
    // Validate the request
    $request->validate([
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
    if (is_array($request->section_name) && is_array($request->section_description)) {
      foreach ($request->section_name as $key => $sectionName) {
        // dd($request->all(),$request->question_text[$i] );
        $sectionDescription = $request->section_description[$key] ?? null;
        $section = Section::create([
          'form_id' => $form['id'],
          'section_name' => $sectionName,
          'section_description' => $sectionDescription,
        ]);

        if (isset($request->question_text[$i]) && is_array($request->question_text[$i])) {
          foreach ($request->question_text[$i] as $key => $questionText) {
            $description = $request->question_description[$i][$key] ?? null;
            $type = $request->type[$i][$key] ?? null;
            $choiceOptions = [];
            $ratingOptions = [];

            // Fetch choice options based on the type
            if (!empty($request->options["choice_{$i}"])) {
              $choiceOptions = $request->options["choice_{$i}"];
            }

            // Fetch rating options if available
            if (!empty($request->options["rating_{$i}"])) {
              $ratingOptions = $request->options["rating_{$i}"];
            }

            // Determine final options to store
            if ($type === 'radio' || $type === 'checkbox') {
              $options = !empty($choiceOptions) ? json_encode($choiceOptions) : null;
            } elseif ($type === 'rating') {
              $options = !empty($ratingOptions) ? json_encode($ratingOptions) : null;
            } else {
              $options = null; // For other types, no options
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
}
