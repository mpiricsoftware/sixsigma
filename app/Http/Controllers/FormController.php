<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use App\Models\form;
use App\Models\Input;
use App\Models\section;
class FormController extends Controller
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
        $query = form::query();

        // Apply search filters if search term exists
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }

        // Get total data count without any filters
        $totalData = form::count();

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

    // Return the view if not an AJAX request
    return view('panel.form.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $form = form::all();
        return view('panel.form.create',compact('form'));
    }

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
        'description' =>$request->description,
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
        $form = Form::where('id',$id)->delete();
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
