<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\subgroup;
use App\Models\SubPlan;

class adminController extends Controller
{
    public function adminManage()
    {
        $users = User::role('Admin')->get();
        // dd($users);
        $userCount = $users->count();
        $verified = User::whereNotNull('email_verified_at')->get()->count();
        $notVerified = User::whereNull('email_verified_at')->get()->count();
        // $usersUnique = $users->unique(['email']);
        // $userDuplicates = $users->diff($usersUnique)->count();
        $subgroup = subgroup::get();
        // $subplan = SubPlan::where('subgroup_id',Auth::user()->subgroup_id)->get();
        $subplan = SubPlan::get();

        return view('panel.admin.index', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            // 'userDuplicates' => $userDuplicates,
            'subgroup' => $subgroup,
            'subplan' => $subplan
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'name',
            3 => 'email',
            5 => 'email_verified_at',
            6 => 'subgroup_id',
            7 => 'subplan_id',
        ];

        $search = [];

        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = User::role('Admin')
            ->with('subgroup')->offset($start)

                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = User::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = User::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        // dd($users);

        if (!empty($users)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id'] = $user->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['email_verified_at'] = $user->email_verified_at;
                $nestedData['subgroup_id'] = $user->subgroup ? $user->subgroup->name : "-";
                $nestedData['subplan_id'] = $user->subplan ? $user->subplan->name : "-";
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
        $userID = $request->id;
        // dd($request->all());

        if ($userID) {
            // update the value
            $users = User::updateOrCreate(
              ['id' => $userID],
              [
                'name' => $request->name,
                'email' => $request->email,
                'subgroup_id' => $request->subgroup_id,
                'subplan_id' => $request->subplan_id
              ],
            );
            $users->syncRoles('Admin');
            return response()->json('Updated');
        } else {
            // create new one if email is unique
            $userEmail = User::where('email', $request->email)->first();
            //  dd($userEmail);
            if (empty($userEmail)) {
                $users = User::updateOrCreate(
                  ['id' => $userID],
                  ['name' => $request->name, 'email' => $request->email, 'usertype' => 'Admin', 'password' => Hash::make('12345678'),
                   'subgroup_id' => $request->subgroup_id,
                   'subplan_id' => $request->subplan_id
                   ]
                );
                $users->assignRole('Admin');
                return response()->json('Created');
            } else {
                return response()->json(['message' => "already exits"], 422);
            }
        }
    }

    public function show($id)
    {
        // $id = $id;
        $user = User::where('id',$id)->first();
        return view('panel.admin.view',compact('user'));
    }
    public function getSubplans(Request $request)
    {
        $subgroupId = $request->input('subgroup_id');
        $subplan = SubPlan::where('subgroup_id', $subgroupId)->get();
        return response()->json(['subplan' => $subplan]);
    }

    public function edit($id): JsonResponse
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $users = User::where('id', $id)->delete();
    }
}
