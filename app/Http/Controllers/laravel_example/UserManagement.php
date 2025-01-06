<?php

namespace App\Http\Controllers\laravel_example;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class UserManagement extends Controller
{
    public function UserManagement()
    {
        // dd('UserManagement');
        $users = User::all();
        $userCount = $users->count();
        $percentage = ($userCount/100) * 100;
        $verified = User::whereNotNull('email_verified_at')->get()->count();
        $notVerified = User::whereNull('email_verified_at')->get()->count();
        $verified_p = ($verified/$userCount) * 100;
        $usersUnique = $users->unique(['email']);
        $userDuplicates = $users->diff($usersUnique)->count();
        $p_duplicates = ($userDuplicates/$userCount) * 100;
        $p_notVerified = ($notVerified/$userCount) *100;
        $companies = company::get();
        $roles = role::get();
        $country = Country::all();
        // dd($roles);

        return view('content.laravel-example.user-management', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'companies' => $companies,
            'roles' => $roles,
            'country' => $country,
            'percentage' => $percentage,
            'verified_p' => $verified_p,
            'p_duplicates' => $p_duplicates,
            'p_notVerified' => $p_notVerified,

        ]);
    }

    public function index(Request $request)
    {
      // dd('re');
        if ($request->ajax()) {

            $columns = [
                1 => 'name',
                2 => 'lastname',
                3 => 'company',
                4 => 'state',
                5 => 'city',
                6 => 'mobileno',
                7 => 'status',
                8 => 'email_verified_at',
            ];
            $search = $request->input('search.value');
            $start = (int) $request->input('start', 0);
            $length = (int) $request->input('length', 10);
            $draw = (int) $request->input('draw', 1);
            $query = User::query();
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'LIKE', "%{$search}%")
                      ->orWhere('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('company', 'LIKE', "%{$search}%");

                });
            }
            $totalData = $query->count();


            $query->offset($start)
                  ->limit($length);
            if ($request->has('order.0.column') && $request->has('order.0.dir')) {
                $orderColumn = $request->input('order.0.column');
                $orderDirection = $request->input('order.0.dir');

                // Map the column index to actual database column names
                $orderByColumn = $columns[$orderColumn] ?? 'id'; // Default to 'id' if not found
                $query->orderBy($orderByColumn, $orderDirection);
            }

            // Get the filtered users
            $users = $query->get();

            // Prepare the data for the response
            $data = [];
            foreach ($users as $user) {
                $nestedData['id'] = $user->id;
                $nestedData['name'] = $user->name;
                $nestedData['lastname'] = $user->lastname;
                $nestedData['email'] = $user->email;
                $nestedData['company'] = $user->company;
                $nestedData['state'] = isset(State::find($user->state)->name) ? State::find($user->state)->name : '';
                $nestedData['city'] = isset(City::find($user->city)->name) ? City::find($user->city)->name : '';
                $nestedData['mobileno'] = $user->mobileno;
                $nestedData['status'] = $user->status;
                $nestedData['email_verified_at'] = $user->email_verified_at;
                $data[] = $nestedData;
            }
            // dd($data);
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data,
            ]);
        }
    }

    public function create()
    {
        //
    }

    public function resetPass(Request $request) {
      $userID = $request->id;
      if ($userID) {
          $existingUser = User::find($userID);
          if ($existingUser) {
              if ($request->filled('newPassword')) {
                if(isset($request->newPassword) && isset($request->newPassword_confirmation) && $request->newPassword == $request->newPassword_confirmation) {
                  $password = Hash::make($request->newPassword);
                    $existingUser->update([
                      'password' => $password,
                  ]);

                  return response()->json(['message' => 'Password changed successfully.']);
                }
                else {
                  return response()->json(['message' => 'Password dose not match.']);
                }

              } else {
                  return response()->json(['error' => 'New password is required.'], 400);
              }


          } else {
              return response()->json(['error' => 'User not found.'], 404);
          }
      }

      return response()->json(['error' => 'User ID is required.'], 400);
  }



  public function store(Request $request)
  {
      // Default role in case no role is provided
      $defaultRole = 'user';  // Or any default role you want

      $userID = $request->id;
      $status = 'approved';

      // Check if updating an existing user
      if ($userID) {
          $existingUser = User::find($userID);

          if ($existingUser) {
              $status = $existingUser->email_verified_at ? 'approved' : 'pending';
          }

          // Handle password update if new password is filled
          if ($request->filled('newPassword')) {
              $request->validate([
                  'newPassword' => 'required|string|min:8|confirmed',
              ]);
          }
      }

      // Get password or assign default password if not provided
      $password = $request->filled('newPassword') ? Hash::make($request->newPassword) : null;

      // Check if user exists, else create
      if ($userID) {
          $users = User::updateOrCreate(
              ['id' => $userID],
              [
                  'name' => $request->name,
                  'email' => $request->email,
                  'username' => $request->username,
                  'lastname' => $request->lastname,
                  'company' => $request->company,
                  'address' => $request->address,
                  'country' => $request->country,
                  'state' => $request->state,
                  'city' => $request->city,
                  'office_no' => $request->office_no,
                  'mobileno' => $request->mobileno,
                  'usertype' => $request->usertype,
                  'status' => $request->status,
                  'password' => $password ?? ($existingUser->password ?? Hash::make('12345678')),
              ]
          );

          // Assign the user role (use provided or default role)
          $role = $request->usertype ?: $defaultRole;  // Assign provided role or default
          $users->syncRoles([$role]);
          if ($users->status == 'approved') {
            $data = ['name' => $users->name, 'email' => $users->email];
            Mail::send('mail.invite', ['data' => $data], function ($message) use ($users) {
                $message->to($users->email)->subject('Invite to join Swft');
            });
        }
          return response()->json('User updated successfully');



      } else {
          // Handle case where user is being created (not updating)

          $userEmail = User::where('email', $request->email)->first();

          if (empty($userEmail)) {
              $users = User::create([
                  'name' => $request->name,
                  'email' => $request->email,
                  'username' => $request->username,
                  'lastname' => $request->lastname,
                  'company' => $request->company,
                  'address' => $request->address,
                  'country' => $request->country,
                  'state' => $request->state,
                  'city' => $request->city,
                  'office_no' => $request->office_no,
                  'mobileno' => $request->mobileno,
                  'usertype' => $request->usertype ?: $defaultRole,
                  'password' => $password ?? Hash::make('12345678'),
                  'status' => $status,
              ]);


              $role = $request->usertype ?: $defaultRole;
              $users->assignRole($role);

              return response()->json('User created successfully');
          }
      }
  }



    public function show($id)
    {

        $user = User::findOrFail($id);
        $countryName = Country::where('id', $user->country)->first();
        $countryName = $countryName->name ?? 'N/A';
        $roleName = $user->roles->first()?->name ?? 'N/A';
        return view('content.laravel-example.user-management-view', compact('user', 'roleName', 'countryName'));
    }

    public function edit($id): JsonResponse
{
    $user = User::findOrFail($id);


    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'username' => $user->username,
        'lastname' => $user->lastname,
        'company' => $user->company,
        'address' => $user->address,
        'country' => $user->country,
        'state' => $user->state,
        'city' => $user->city,
        'office_no' => $user->office_no,
        'mobileno' => $user->mobileno,
        'usertype' => $user->usertype,
    ]);
}



    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        // $users = User::where('id', $id)->delete();
    }
    public function getstate(Request $request)
    {
         $countryID = $request->input('country_id');
         $state = State::where('country_id',$countryID)->get();
         return response()->json(['state' => $state]);
    }
    public function getcity(Request $request)
    {
       $stateId = $request->input('state_id');
       $city = City::where('state_id',$stateId)->get();
       return response()->json(['city' => $city]);
    }

    public function migrate()
    {
        Artisan::call('migrate');
        return response()->json(['message' => 'Migration Run successfully'], 200);
    }
}
