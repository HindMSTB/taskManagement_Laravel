<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        // Mettre à jour le statut de l'utilisateur au lieu de le supprimer définitivement
        $user->update(['status' => 0]);
        
        // Enregistrer l'utilisateur qui a supprimé le compte
        $deletedBy =auth()->user();

        // Enregistrer la date et l'heure de la suppression
        $dateSuppression= now();


       
        $user->update([
            'deletedBy' => $deletedBy->name,
            'dateSuppression' => $dateSuppression
        ]);
        
        // Effacer la photo de profil de l'utilisateur
        $user->deleteProfilePhoto();
        
        // Révoquer tous les tokens d'accès de l'utilisateur
        $user->tokens->each->delete();
    }
}
