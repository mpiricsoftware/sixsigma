<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subgroup;

class subgroupController extends Controller
{
    public function subgroupMange()
    {
        return view('subscription.subscriptiongroup');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search.value');
            $start = (int) $request->input('start', 0);
            $length = (int) $request->input('length', 10);
            $draw = (int) $request->input('draw', 1);

            $query = Subgroup::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'LIKE', "%{$search}%")
                      ->orWhere('name', 'LIKE', "%{$search}%")
                      ->orWhere('priority', 'LIKE', "%{$search}%");
                });
            }

            $totalData = Subgroup::count();
            $filteredData = $query->count();

            $subgroup = $query->offset($start)
                ->limit($length)
                ->get();

            $data = $subgroup->map(function ($subgroup) {
                return [
                    'id' => $subgroup->id,
                    'name' => $subgroup->name,
                    'priority' => $subgroup->priority,
                ];
            });

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalData,
                'recordsFiltered' => $filteredData,
                'data' => $data,
            ]);
        }

        return view('subscription.subscriptiongroup');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:subgroup,id',
            'name' => 'required|string|max:255',
            'priority' => 'required|integer',
        ]);

        $subgroup = Subgroup::updateOrCreate(
            ['id' => $validated['id']],
            [
                'name' => $validated['name'],
                'priority' => $validated['priority'],
            ]
        );

        return response()->json(['message' => 'Subgroup saved successfully', 'subgroup' => $subgroup], 200);
    }

    public function show(string $id)
    {
        $subgroup = Subgroup::findOrFail($id);
        return response()->json($subgroup);
    }

    public function edit(string $id)
    {
        $subgroup = Subgroup::findOrFail($id);
        return response()->json($subgroup);
    }

    public function update(Request $request, string $id)
    {
        $subgroup = Subgroup::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|integer',
        ]);

        $subgroup->update($validated);

        return response()->json(['message' => 'Subgroup updated successfully', 'subgroup' => $subgroup], 200);
    }

    public function destroy(string $id)
    {
        $subgroup = Subgroup::findOrFail($id);
        $subgroup->delete();

        return response()->json(['message' => 'Subgroup deleted successfully'], 200);
    }
}
