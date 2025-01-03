<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'mobileno' => ['required', 'string', 'max:20'],
            'company' => ['required', 'string' , 'max:200'],
            'designation' => ['required','string', 'max:200'],
            'company_size' => ['required', 'string', 'max:200'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',

        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'lastname' => $input['lastname'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'mobileno' => $input['mobileno'],
                'company' => $input['company'],
                'designation' => $input['designation'],
                'company_size' => $input['company_size'],
                'status' => 'pending',

            ]), function (User $user) {
                $this->createTeam($user);
                $user->assignRole('user');
                // Auth::login($user);
                // return Redirect::route('login');
            });
        });
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}
