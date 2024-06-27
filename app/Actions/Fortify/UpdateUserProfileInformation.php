<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'dateNaissance' => ['required', 'date'],
            'adresse' => ['required', 'string', 'max:255'],
            'num' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        // Récupérer l'utilisateur actuel
        $currentUser = auth()->user();
      
        // Générer la date et l'heure actuelles
        $input['dateModification'] = now();

        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'dateNaissance' => $input['dateNaissance'],
                'adresse' => $input['adresse'],
                'num' => $input['num'],
                'dateModification' => $input['dateModification'], // Mettre à jour la date de modification
                'modifiedBy' => $currentUser->id, // Mettre à jour le champ modifiedBy avec l'ID de l'utilisateur actuel
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'dateNaissance' => $input['dateNaissance'],
            'adresse' => $input['adresse'],
            'num' => $input['num'],
            'dateModification' => $input['dateModification'], // Mettre à jour la date de modification
            'modifiedBy' => $input['modifiedBy'], // Mettre à jour le nom de l'utilisateur modifié par
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
