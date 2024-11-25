<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPlan;
use App\Models\subgroup;

class SubPlanController extends Controller
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

    $query = SubPlan::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('id', 'LIKE', "%{$search}%")
              ->orWhere('name', 'LIKE', "%{$search}%")
              ->orWhere('price', 'LIKE', "%{$search}%")
              ->orwhere('option','LIKE',"%{$search}%");
        });
    }

    $totalData = SubPlan::count();
    $filteredData = $query->count();

    $subplan = $query->offset($start)
        ->limit($length)
        ->get();

    $data = $subplan->map(function ($subplan) {
        return [
            'id' => $subplan->id,
            'subgroup_id' => $subplan->subgroup_id,
            'name' => $subplan->name,
            'price' => $subplan->price,
            'option' => $subplan->option,
            'user_limit' => $subplan->user_limit,
            'site_limit' => $subplan->site_limit,
            'company_limit' => $subplan->company_limit,
            'features' => $subplan->features,
            'description' => $subplan->description,
        ];
    });

    return response()->json([
        'draw' => $draw,
        'recordsTotal' => $totalData,
        'recordsFiltered' => $filteredData,
        'data' => $data,
    ]);
  }

  $subgroup = Subgroup::all();
  $subplan = SubPlan::all();
  return view('subscription.subplan', compact('subgroup', 'subplan'));
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
      $validated = $request->validate([
        'id' => 'nullable|exists:subplan,id',
        'subgroup_id' => 'required|exists:subgroup,id',
        'name' => 'required|string|max:255',
        'price' => 'required|integer',
        'option' => 'required|string|in:monthly,yearly',
        'user_limit' => 'required|integer',
        'site_limit' => 'required|integer',
        'company_limit' => 'required|integer',
        'features' => 'required|string',
        'description' => 'required|string',
      ]);
      $subplan = SubPlan::updateOrCreate(
        ['id' => $validated['id']],
        [
          'subgroup_id' => $validated['subgroup_id'],
          'name' => $validated['name'],
          'price' => $validated['price'],
          'option' => $validated['option'],
          'user_limit' => $validated['user_limit'],
          'site_limit' => $validated['site_limit'],
          'company_limit' => $validated['company_limit'],
          'features' => $validated['features'],
          'description' => $validated['description']
        ]
      );

        return response()->json(["message" => ' store Successfully','subplan' => $subplan], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subplan = SubPlan::findOrFail($id);
        return response()->json($subplan);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subplan = SubPlan::findOrFail($id);
        return response()->json($subplan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $validated = $request->validate([
        'id' => 'nullable|exists:subplan,id',
        'subgroup_id' => 'required|exists:subgroup,id',
        'name' => 'required|string|max:255',
        'price' => 'required|integer',
        'option' => 'required|string|in:monthly,yearly',
        'user_limit' => 'required|integer',
        'site_limit' => 'required|integer',
        'company_limit' => 'required|integer',
        'features' => 'required|string',
        'description' => 'required|string',
    ]);

    $subplan = SubPlan::findOrFail($id);
    $subplan->update($validated);

    return response()->json([
        "message" => 'SubPlan updated successfully',
        'subplan' => $subplan
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subplan = SubPlan::findOrFail($id);
        $subplan->delete();
        return response()->json(["message" => 'Delete Successfully','subplan'=>$subplan], 200);
    }
}
