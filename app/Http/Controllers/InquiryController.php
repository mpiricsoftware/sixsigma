<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use App\Models\inquiry;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
      $userID =  auth()->user()->id;
      $user = User::find($userID);
      // dd($user);
      return view('panel.question.details',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $userID = auth()->user()->id;

        $inquiry = Inquiry::create([
            'user_id' => $userID,
            'email' => $request->email,
            'Phone_no' => $request->Phone_no,
            'date_time' => $request->date_time,
        ]);

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
}
