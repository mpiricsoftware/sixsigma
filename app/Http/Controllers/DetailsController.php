<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\form;
use App\Models\Details;

class DetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

      {

        if ($request->ajax()) {

          $columns = [
              1 => 'name',
              2 => 'email',


          ];
          $search = $request->input('search.value');
          $start = (int) $request->input('start', 0);
          $length = (int) $request->input('length', 10);
          $draw = (int) $request->input('draw', 1);
          // $userID = user()->id;
          // dd($userID);

          $query = Details::query()
          ->Join('users', 'details.user_id', '=', 'users.id')
          ->leftjoin('form', 'details.form_id', '=', 'form.id')
          ->select(
              'details.*',
              'users.name as user_name',
              'users.email as user_email',
              'form.name as form_name',
              'form.description as form_description'
          );

$details = $query->get();

          // dd($details);
          if ($search) {
              $query->where(function ($q) use ($search) {
                  $q->where('id', 'LIKE', "%{$search}%");

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
          $details = $query->get();

          // Prepare the data for the response
          $data = [];
          $fackid = 1;
          foreach ($details as $i) {
            $nestedData['fack_id'] = $fackid;
            $nestedData['id'] = $i->id; // Ensure this is the correct details_id
            $nestedData['form_id'] = $i->form_id;
            $nestedData['form_name'] = $i->form_name;
            $nestedData['user_id'] = $i->user_id; // Add user_id to the data
            $nestedData['form_description'] = $i->form_description;
            $nestedData['user_name'] = $i->user_name;
            $nestedData['user_email'] = $i->user_email;
            $data[] = $nestedData;
            $fackid++;
        }
          // dd($data);
          return response()->json([
              'draw' => $draw,
              'recordsTotal' => $totalData,
              'recordsFiltered' => $totalData,
              'data' => $data,
          ]);
      }

        return view('panel.form.details');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
