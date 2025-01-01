<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Input;

class InputController extends Controller
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
        $query = Input::query();

        // Apply search filters if search term exists
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }

        // Get total data count without any filters
        $totalData = Input::count();

        // Get the count of filtered data based on search
        $filteredData = $query->count();

        // Retrieve the filtered results with pagination
        $inputs = $query->offset($start)
                        ->limit($length)
                        ->get();

        // Map the results into the desired format for DataTables
        $data = $inputs->map(function ($input) {
            return [
                'id' => $input->id,
                'name' => $input->name,
                'type' => $input->type,
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
    return view('panel.input.index');
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = Input::create(
          [
              'name' => $request->name,
              'icon' => $request->icon,
              'html_code' => $request->html_code,
              'type' => $request->type,
          ]);
          return response()->json('created');

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
        $input = input::where('id',$id)->delete();
        // return $input;

    }
}
