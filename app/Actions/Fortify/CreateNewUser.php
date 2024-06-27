<?php

namespace App\Actions\Fortify;
// app/Actions/Fortify/CreateNewUser.php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'dateNaissance' => ['required', 'date'],
            'adresse' => ['required', 'string', 'max:255'],
            'num' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'dateNaissance' => $input['dateNaissance'],
            'adresse' => $input['adresse'],
            'num' => $input['num'],
        ]);

        $user->sendEmailVerificationNotification();

        return $user;
    }
}
