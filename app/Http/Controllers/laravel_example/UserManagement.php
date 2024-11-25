<?php

namespace App\Http\Controllers\laravel_example;

use App\Http\Controllers\Controller;
use App\Models\company;
use App\Models\Department;
use App\Models\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Controller
{
    public function UserManagement()
    {
        // dd('UserManagement');
        $users = User::all();
        $userCount = $users->count();
        $verified = User::whereNotNull('email_verified_at')->get()->count();
        $notVerified = User::whereNull('email_verified_at')->get()->count();
        $usersUnique = $users->unique(['email']);
        $userDuplicates = $users->diff($usersUnique)->count();
        $companies = company::get();
        $sites = Site::where('comp_id',Auth::user()->company_id)->get();
        $departments = Department::where('comp_id',Auth::user()->company_id)->get();
        return view('content.laravel-example.user-management', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'companies' => $companies,
            'sites' => $sites,
            'departments' => $departments,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'name',
            3 => 'email',
            4 => 'company_id',
            // 5 => 'email_verified_at',
        ];

        $search = [];

        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = User::offset($start)
                ->with('company')
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = User::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhereHas('company',function($query) use($search) {
                    $query->where('company_name','LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = User::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhereHas('company',function($query) use($search) {
                    $query->where('company_name','LIKE', "%{$search}%");
                })
                ->count();
        }
        $data = [];

        if (!empty($users)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id'] = $user->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['company'] = $user->company->company_name;
                $nestedData['email_verified_at'] = $user->email_verified_at;

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
                    'company_id' => $request->company_id,
                    'site_id' => $request->site_id,
                    'department_id' => $request->department_id,
                    // 'usertype' => 'User'
                ]
            );
            $users->syncRoles('User');
            // user updated
            return response()->json('Updated');
        } else {
            // create new one if email is unique
            $userEmail = User::where('email', $request->email)->first();

            if (empty($userEmail)) {
                $users = User::updateOrCreate(
                    ['id' => $userID],
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'company_id' => $request->company_id,
                        'site_id' => $request->site_id,
                        'department_id' => $request->department_id,
                        'usertype' => 'User',
                        'password' => Hash::make('12345678'),
                        'status' => '1'
                    ]
                );
                $users->assignRole('User');
                // user created
                return response()->json('Created');
            } else {
                // user already exist
                return response()->json(['message' => "already exits"], 422);
            }
        }
    }

    public function show($id)
    {
        // $id = $id;
        $user = User::where('id',$id)->first();
        // dd($user);
        return view('content.laravel-example.user-management-view',compact('user'));
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
