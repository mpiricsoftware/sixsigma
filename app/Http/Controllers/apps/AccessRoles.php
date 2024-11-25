<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccessRoles extends Controller
{
    /**
     * Show the role management view with roles and permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function AccessRole()
    {
        $roles = Role::all(); 
        $permissions = Permission::all(); 
        
      
        $rolePermissions = [];
        foreach ($roles as $role) {
            $rolePermissions[$role->id] = $role->permissions->pluck('name')->toArray();
        }

        return view('content.apps.app-access-roles', [
            'roles' => $roles,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions 
        ]);
    }

    /**
     * Display a listing of roles for DataTables.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'name',
            3 => 'assigned_to',
            4 => 'created_date',
        ];

        $search = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $query = Role::query();

        if (!empty($search)) {
            $query->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%");
        }

        $totalData = Role::count();
        $totalFiltered = $query->count();

        $roles = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = $roles->map(function ($role, $index) use ($start) {
            return [
                'id' => $role->id,
                'fake_id' => $start + $index + 1,
                'name' => $role->name,
                'assigned_to' => $role->users->pluck('name')->implode(', '),
                'created_date' => Carbon::parse($role->created_at)->format('d M Y H:i:s'),
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    }

    /**
     * Store or update a role with permissions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'modalRoleName' => 'required|string|max:255',
            'permission' => 'array', // Validate that permissions is an array
        ]);

        $roleId = $request->input('roleId');
        $roleData = ['name' => $request->input('modalRoleName')];

        if ($roleId) {
           
            $role = Role::find($roleId);
            if ($role) {
                $role->update($roleData);
                $role->syncPermissions($request->input('permission', []));
                return response()->json('Updated');
            } else {
                return response()->json(['message' => 'Role not found'], 404);
            }
            
        } else {
          
            $roleExists = Role::where('name', $request->input('modalRoleName'))->exists();
            if (!$roleExists) {
                $role = Role::create($roleData);
                $role->syncPermissions($request->input('permission', []));
                return response()->json('Created');
            } else {
                return response()->json(['message' => 'Role already exists'], 422);
            }
        }
        return redirect()->route('app-access-roles')->with('success', 'Role added/updated successfully!');
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return redirect()->route('app-access-roles')->with('error', 'Role not found');
        }

        return view('content.apps.edit-role', [
            'role' => $role,
            'rolePermissions' => $role->permissions->pluck('name')->toArray(),
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Update the specified role in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'modalRoleName' => 'required|string|max:255',
            'permission' => 'array',
        ]);

        $role = Role::find($id);
        if ($role) {
            $role->name = $request->input('modalRoleName');
            $role->save();
            $role->syncPermissions($request->input('permission', []));
            return redirect()->route('app-access-roles')->with('success', 'Role updated successfully!');
        } else {
            return redirect()->route('app-access-roles')->with('error', 'Role not found!');
        }
    }

    /**
     * Remove the specified role from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return response()->json(['message' => 'Role deleted successfully.']);
        } else {
            return response()->json(['message' => 'Role not found.'], 404);
        }
    }
}
