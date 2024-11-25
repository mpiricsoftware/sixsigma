<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function siteManage()
    {
        $sites = Site::where('comp_id',Auth::user()->company_id)->get();
        // dd($sites);
        $companies = company::get();
        // dd($companies);
        return view('panel.site.index', [
            'companies' => $companies,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'name',
            3 => 'comp_id',
        ];

        $search = [];

        $totalData = Site::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $sites = Site::where('comp_id',Auth::user()->company_id)
                ->offset($start)
                ->with('company')
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $sites = Site::where('id', 'LIKE', "%{$search}%")
                ->orWhere('comp_id',Auth::user()->company_id)
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhereHas('company',function($query) use($search) {
                    $query->whereHaorWhereHas('company_name','LIKE', "%{$search}%");
                })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Site::where('id', 'LIKE', "%{$search}%")
                ->orWhere('comp_id',Auth::user()->company_id)
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('company',function($query) use($search) {
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
        $siteID = $request->id;
        // dd($request->all());
        if ($siteID) {
            // update the value
            $sites = Site::updateOrCreate(
              ['id' => $siteID],
              ['name' => $request->name, 'comp_id' => $request->comp_id]
            );
            return response()->json('Updated');
        } else {
            // create new site
            $sites = Site::updateOrCreate(
              ['id' => $siteID],
              ['name' => $request->name, 'comp_id' => $request->comp_id]
            );
            return response()->json('Created');
        }
    }

    public function show(Site $site)
    {
        //
    }

    public function edit($id)
    {
        $site = Site::findOrFail($id);
        return response()->json($site);
    }

    public function update(Request $request, Site $site)
    {
        //
    }

    public function destroy($id)
    {
        $sites = Site::where('id', $id)->delete();
    }
}
