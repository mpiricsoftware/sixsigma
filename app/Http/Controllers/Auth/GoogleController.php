<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
  public function redirectToGoogle()
  {
      // dd('hii');
      return Socialite::driver('google')->redirect();
  }

  public function handleGoogleCallback()
  {
    try {

      $user = Socialite::driver('google')->user();
      $finduser = User::where('google_id', $user->id)->first();

      if ($finduser) {
          Auth::login($finduser);
          if ($finduser->email_verified_at === null) {
              $finduser->email_verified_at = now();
              $finduser->save();
          }

          return redirect()->intended('dashboard');
      } else {

          $newUser = User::create([
              'name' => $user->name,
              'email' => $user->email,
              'google_id' => $user->id,
              'password' => Hash::make('12345678'),
              'email_verified_at' => now(),
          ]);
          Auth::login($newUser);

          return redirect()->intended('dashboard');
      }
  } catch (\Exception $e) {
      dd($e->getMessage());
  }
}

}
