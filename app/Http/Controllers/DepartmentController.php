<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\company;
use App\Models\Site;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function departmentManage()
    {
        $departments = Department::get();
        // dd($users);
        $sites = Site::get();
        $companies = company::get();
        // dd($companies);
        return view('panel.department.index', [
            'sites' => $sites,
            'companies' => $companies,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'name',
            3 => 'site_id',
            4 => 'comp_id'
        ];

        $search = [];

        $totalData = Department::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $sites = Department::offset($start)
                ->with('site','company')
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $sites = Department::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhereHas('site',function($query) use($search) {
                    $query->where('name','LIKE', "%{$search}%");
                })->orWhereHas('company',function($query) use($search) {
                    $query->where('company_name','LIKE', "%{$search}%");
                })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Department::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhereHas('site',function($query) use($search) {
                    $query->where('name','LIKE', "%{$search}%");
                })->orWhereHas('company',function($query) use($search) {
                    $query->where('company_name','LIKE', "%{$search}%");
                })->count();
        }
        $data = [];
        // dd($sites);
        if (!empty($sites)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($sites as $site) {
                $nestedData['id'] = $site->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['name'] = $site->name;
                $nestedData['site'] = $site->site->name;
                $nestedData['company'] = $site->company->company_name;

                $data[] = $nestedData;
            }
        }

        if ($data) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'code' => 200,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
                'data' => [],
            ]);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $departmentID = $request->id;
        // dd($request->all());
        if ($departmentID) {
            // update the value
            $departments = Department::updateOrCreate(
              ['id' => $departmentID],
              ['name' => $request->name, 'site_id' => $request->site_id, 'comp_id' => $request->comp_id]
            );
            return response()->json('Updated');
        } else {
            // create new site
            $departments = Department::updateOrCreate(
              ['id' => $departmentID],
              ['name' => $request->name, 'site_id' => $request->site_id, 'comp_id' => $request->comp_id]
            );
            return response()->json('Created');
        }
    }

    public function show(Department $department)
    {
        //
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return response()->json($department);
    }

    public function update(Request $request, Department $department)
    {
        //
    }

    public function destroy($id)
    {
        $departments = Department::where('id', $id)->delete();
    }
}
