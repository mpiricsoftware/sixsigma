<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use illuminate\Support\Facades\Auth;
use Hash;
use Str;

class LoginBasic extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  // public function google()
  // {
  //      return Socialite::driver('google')->redirect();
  // }

  // public function redirect()
  // {
  //    $user =  Socialite::driver('google')->user();
  //    $existingUser = User::where('email', $user->getEmail())->first();
  //    if ($existingUser) {
  //     Auth::login($existingUser, true);
  // } else {

  //     $newUser = User::create([
  //         'name' => $user->getName(),
  //         'email' => $user->getEmail(),
  //         'password' => bcrypt('defaultpassword'),
  //     ]);

  //     Auth::login($newUser, true);
  // }

  // }
}
