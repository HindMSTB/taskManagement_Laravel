<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => $this->passwordRules(),
        ], [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ])->validateWithBag('updatePassword');

        // Récupérer le nom d'utilisateur actuel
        $currentUser = auth()->user();

        // Générer la date et l'heure actuelles
        $dateModification = now();

        $user->forceFill([
            'password' => Hash::make($input['password']),
            'modifiedBy' =>   $currentUser->id, // Mettre à jour le nom de l'utilisateur modifié par
            'dateModification' => $dateModification, // Mettre à jour la date de modification
        ])->save();
    }
}
