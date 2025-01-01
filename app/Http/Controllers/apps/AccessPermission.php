<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class AccessPermission extends Controller
{
  /**
   * Redirect to user-management view.
   *
   */
  public function AccessPermission()
  {
    // dd('UserManagement');
    // $users = User::all();
    // $userCount = $users->count();
    // $verified = User::whereNotNull('email_verified_at')->get()->count();
    // $notVerified = User::whereNull('email_verified_at')->get()->count();
    // $usersUnique = $users->unique(['email']);
    // $userDuplicates = $users->diff($usersUnique)->count();

    return view('content.apps.app-access-permission');

    // return view('content.laravel-example.user-management', [
    //   'totalUser' => $userCount,
    //   'verified' => $verified,
    //   'notVerified' => $notVerified,
    //   'userDuplicates' => $userDuplicates,
    // ]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'name',
      3 => 'assigned_to',
      4 => 'created_date',
    ];

    $search = [];

    $totalData = Permission::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $Permissions = Permission::offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $Permissions = Permission::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Permission::where('id', 'LIKE', "%{$search}%")
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($Permissions)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($Permissions as $Permission) {
        // dd($Permission->id, $Permission->roles->pluck('name'));
        $nestedData['id'] = $Permission->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $Permission->name;
        $nestedData['assigned_to'] = $Permission->roles->pluck('name');
        $nestedData['created_date'] = Carbon::parse($Permission->created_at)->format('d M Y H:i:s');

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

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    // dd($request->all());
    $permissionID = $request->permissionID;

    if ($permissionID) {
      // update the value
      $permissions = Permission::updateOrCreate(
        ['id' => $permissionID],
        ['name' => $request->modalPermissionName]
      );

      // Permission updated
      return response()->json('Updated');
    } else {
      // create new one if Permission is unique
      $userEmail = Permission::where('name', $request->modalPermissionName)->first();

      if (empty($userEmail)) {
        $permissions = Permission::updateOrCreate(
          ['id' => $permissionID],
          ['name' => $request->modalPermissionName]
        );

        // Permission created
        return response()->json('Created');
      } else {
        // Permission already exist
        return response()->json(['message' => "already exits"], 422);
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id): JsonResponse
  {
    $permission = Permission::findOrFail($id);
    return response()->json($permission);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {}

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $permissions = Permission::where('id', $id)->delete();
  }
}
