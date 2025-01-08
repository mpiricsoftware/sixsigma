<?php

namespace App\Http\Controllers\dashboard;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\form;
use App\Models\inquiry;
use Illuminate\Http\Request;

class Analytics extends Controller
{
  public function index()
{

  $forms = form::all();

  $inquiry = inquiry::all();
    // Get the currently authenticated user
    $user = auth()->user();

    // Check if the user's status is 'approved' or 'pending'
    if ($user->status === 'pending') {
        // Redirect to a page that informs the user their account is pending approval
        return view('content.dashboard.not-approved');
    }


    // dd($forms);
    return view('content.dashboard.dashboards-crm',compact('forms','inquiry'));
}

public function display(Request $request,$id)
{

    $userID = $request->user()->id;
    $forms = Form::findOrFail($id);
    // dd($forms);
    $inquiry = Inquiry::where('user_id', $userID)->get();
    // dd($inquiry);
    return view('content.dashboard.dashboards-analytics', compact('inquiry','forms'));
}

}
