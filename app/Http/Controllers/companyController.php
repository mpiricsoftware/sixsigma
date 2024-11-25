<?php

namespace App\Http\Controllers;
use App\Models\company;
use App\Models\User;
use App\Models\country;
use App\Models\state;
use App\Models\city;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;

class companyController extends Controller
{
    public function CompanyManage()
    {
        $company = Company::all();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        // dd($company);
        return view('panel.company.index', compact('company', 'countries', 'states','cities'));
    }

    public function index(Request $request)
    {
        // dd($request->all());
        $columns = [
            1 => 'id',
            2 => 'company_name',
            3 => 'email'
        ];

        $search = [];

        $totalData = Company::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $sites = Company::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $sites = Company::where('id', 'LIKE', "%{$search}%")
                ->orWhere('company_name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Company::where('id', 'LIKE', "%{$search}%")
                ->orWhere('company_name', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = [];
        // dd($sites);
        if (!empty($sites)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($sites as $site) {
                $nestedData['id'] = $site->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['company_name'] = $site->company_name;
                $nestedData['email'] = $site->email;
                // $nestedData['gst'] = $site->gst;
                // $nestedData['cin_no'] = $site->cin_no;
                // $nestedData['billing_address'] = $site->billing_address;
                $nestedData['country'] = $site->country->name;
                $nestedData['state'] = $site->state->name;
                $nestedData['city'] = $site->city->name;
                // $nestedData['billing_zipcode'] = $site->billing_zipcode;

                $data[] = $nestedData;
            }
        }
        // dd($data);

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
        // dd($request->all());
        $companyID = $request->id;
        $userID = $request->user_id;

        // Validation (optional)
        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gst' => 'required|string|max:255',
            'cin_no' => 'required|string|max:255',
            'billing_zipcode' => 'required|string|max:10',
            'billing_address' => 'required|string|max:500',
            'billing_country' => 'required|integer',
            'billing_state' => 'required|integer',
            'billing_city' => 'required',
        ]);

        if ($companyID) {
            // Update the existing company
            $company = Company::updateOrCreate(['id' => $companyID],
            [
                'company_name' => $request->company_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gst' => $request->gst,
                'cin_no' => $request->cin_no,
                'billing_zipcode' => $request->billing_zipcode,
                'billing_address' => $request->billing_address,
                'billing_country' => $request->billing_country,
                'billing_state' => $request->billing_state,
                'billing_city' => $request->billing_city
            ]);
            $users = User::updateOrCreate(['id' => $userID],
            [
                'name' => $request->company_name,
                'email' =>  $request->email,
            ]);
            $users->syncRoles('Company');
            return response()->json('Updated');
        } else {
            // Create a new company
            $company = Company::create([
                'user_id' => Auth::user()->id,
                'company_name' => $request->company_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gst' => $request->gst,
                'cin_no' => $request->cin_no,
                'billing_zipcode' => $request->billing_zipcode,
                'billing_address' => $request->billing_address,
                'billing_country' => $request->billing_country,
                'billing_state' => $request->billing_state,
                'billing_city' => $request->billing_city
            ]);
            $users = User::create([
                'name' => $request->company_name,
                'email' =>  $request->email,
                'usertype' => 'Company',
                'company_id' => $company->id,
                'password' => Hash::make('12345678'),
                'status' => '1'
            ]);
            $users->assignRole('Company');
            return response()->json('Created');
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $user = User::where('company_id',$id)->where('usertype','Company')->first();
        $data = [
            'company' => $company,
            'user' => $user
        ];
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
    {
        $companyDetails = Company::findOrFail($id);
        $user = User::where('id',$companyDetails->user_id)->delete();
        $company = Company::where('id', $id)->delete();
    }

    public function getstate(Request $request)
    {
        $countryId = $request->input('country_id');
        $states = state::where('country_id', '=', $countryId)->get();
        // dd($states, $request->input('country_id'));
        return response()->json(['states' => $states]);
    }

    public function getcities(Request $request)
    {
        $stateId = $request->input('state_id');
        $cities = City::where('state_id',$stateId)->get();
        // dd($cities);
        return response()->json(['cities' => $cities]);
    }
}
