<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use App\Models\inquiry;
use App\Models\form;
class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      // dd('hi');
      if ($request->ajax()) {

        $columns = [
            1 => 'name',
            2 => 'company',
            3 => 'date_time',
            4 => 'designation',
            5 => 'type',

        ];
        $search = $request->input('search.value');
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $draw = (int) $request->input('draw', 1);
        $query = inquiry::query();
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
        $inquiry = $query->get();

        $fackId = 1;
        $data = [];
        foreach ($inquiry as $i) {
            $nestedData['fack_id'] = $fackId;
            $nestedData['form_id'] = $i->form_id;
            $nestedData['name'] = $i->name;
            $nestedData['email'] = $i->email;
            $nestedData['Phone_no'] = $i->Phone_no;
            $nestedData['company'] = $i->company;
            $nestedData['form_name'] = $i->form_name;
            $nestedData['date_time'] = $i->date_time;
            $nestedData['designation'] = $i->designation;
            $nestedData['type'] = $i->type;
            $nestedData['user_id'] = $i->user_id;

            $data[] = $nestedData;
            $fackId++;
        }
        // dd($inquiry);
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $data,
        ]);
    }

        return view('panel.question.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
      // $userID =  auth()->user()->id;
      // $user = User::find($userID);
      // $form = Form::all();
      // return view('panel.question.details',compact('user','form'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

    $userID = auth()->user()->id;


    $inquiry = Inquiry::updateOrCreate(
        ['user_id' => $userID],
        [
            'name' => $request->name,
            'company' => $request->company,
            'designation' => $request->designation,
            'email' => $request->email,
            'Phone_no' => $request->Phone_no,
            'date_time' => $request->date_time,
            'type' => $request->type,
            'form_name' => $request->form_name,
            'form_id' => $request->id
        ]
    );
// dd($request->all());
    // Return the appropriate view
    return view('panel.question.message');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
    public function message(Request $request)
    {
       return view('panel.question.message');
    }
    public function details(Request $request,$slug)
    {
      $userID =  auth()->user()->id;
      $user = User::find($userID);
      $form = Form::where('slug',$slug)->firstOrFail();
      // dd($form);
      return view('panel.question.details',compact('user','form'));
    }
}
