<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\User;
class UserViewAccount extends Controller
{
  public function index($id)
  {
    $user = User::findOrFail($id);
    $countryName = Country::where('id', $user->country)->first();
    $countryName = $countryName->name ?? 'N/A';
    $roleName = $user->roles->first()?->name ?? 'N/A';
    return view('content.apps.app-user-view-account',compact('user','countryName','roleName'));
  }
}
