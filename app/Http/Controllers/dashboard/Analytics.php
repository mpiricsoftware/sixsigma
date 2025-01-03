<?php

namespace App\Http\Controllers\dashboard;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Analytics extends Controller
{
  public function index()
{
    // Get the currently authenticated user
    $user = auth()->user();

    // Check if the user's status is 'approved' or 'pending'
    if ($user->status === 'pending') {
        // Redirect to a page that informs the user their account is pending approval
        return view('content.dashboard.not-approved');
    }

    // If the status is 'approved', show the normal dashboard page
    return view('content.dashboard.dashboards-analytics');
}

}
