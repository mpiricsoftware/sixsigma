<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pillar;
use App\Models\form;

class PillarController extends Controller
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


        $query = pillar::query();


        if ($search) {
          $query->where(function ($q) use ($search) {
            $q->where('id', 'LIKE', "%{$search}%")
              ->orWhere('name', 'LIKE', "%{$search}%");
          });
        }


        $totalData = pillar::count();

        // Get the count of filtered data based on search
        $filteredData = $query->count();

        // Retrieve the filtered results with pagination
        $pillar = $query->offset($start)
          ->limit($length)
          ->get();


          $fackId = 1; // Initialize before mapping

          $data = $pillar->map(function ($pillar) use (&$fackId) {
              return [
                  'fack_id' => $fackId++, // Use and then increment
                  'id' => $pillar->id,
                  'name' => $pillar->name,
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
        return view('panel.pillar.index');
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
      $user_id =  auth()->user()->id;
      $form = form::pluck('id')->first();
      // dd($form);
      $pillar = pillar::create([
        'form_id' => $form,
        'user_id' => $user_id,
        'name' =>$request->name ?? '',
        'description' =>$request->description
      ]);
      // dd($request->all());
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
        $pillar = Pillar::where('id',$id)->delete();
    }
}
