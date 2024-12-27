<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;

class UserViewSecurity extends Controller
{
  public function index($id)
  {
    $user = User::findOrFail($id);
    $countryName = Country::where('id', $user->country)->first();
    $countryName = $countryName->name ?? 'N/A';
    $roleName = $user->roles->first()?->name ?? 'N/A';
    return view('content.apps.app-user-view-security',compact('user','countryName','roleName'));
  }
}
