<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use App\Models\form;
use App\Models\Input;
use App\Models\Question;
use App\Models\section;
use Illuminate\Http\JsonResponse;

class FormController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {

      $search = $request->input('search.value');
      $start = (int) $request->input('start', 0);
      $length = (int) $request->input('length', 10);
      $draw = (int) $request->input('draw', 1);


      $query = form::query();


      if ($search) {
        $query->where(function ($q) use ($search) {
          $q->where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%");
        });
      }


      $totalData = form::count();

      // Get the count of filtered data based on search
      $filteredData = $query->count();

      // Retrieve the filtered results with pagination
      $forms = $query->offset($start)
        ->limit($length)
        ->get();


        $fackId = 1; // Initialize before mapping

        $data = $forms->map(function ($form) use (&$fackId) {
            return [
                'fack_id' => $fackId++, // Use and then increment
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

    // Return the view if not an AJAX request
    return view('panel.form.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {}

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // dd($request->all());
    $user_id = Auth::user()->id;
    $authID = Auth::id();
    $form = Form::create([
      'name' => $request->name,
      'description' => $request->description,
      'slug' => $request->slug,
      'user_id' => $user_id,
    ]);



    // Return a JSON response with success message
    return response()->json([
      'message' => 'Form created successfully',
      'form' => $form,

    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
      $form = form::where('id',$id)->get();
      $sections = Section::where('form_id', $id)
    ->with(['question' => function ($query) use ($id) {
        $query->where('form_id', $id);
    }])
    ->get();
    foreach ($sections as $section) {
      foreach ($section->question as $question) {
          $question->options = $question->options ? json_decode($question->options, true) : [];
      }
  }

// dd($sections);
      return view('panel.form.show',compact('form','sections'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(String $id) {}

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
    $form = Form::where('id', $id)->delete();
  }
  public function getInputFields(Request $request)
  {
    // Fetch all input fields from the 'inputs' table (adjust the table name as per your model)
    $inputs = Input::select('id', 'name', 'html_code')->get();

    // Return the response in JSON format
    return response()->json([
      'inputs' => $inputs
    ]);
  }
}
