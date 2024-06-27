<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GestionComptesController extends Controller
{
    /**
     * Affiche le formulaire de création de compte.
     *
     * @return \Illuminate\View\View
     */
    public function creerCompteForm()
    {
        return view('gestionAdmin.creerCompteForm');
    }
    
    /**
     * Valide et ajoute un nouveau compte utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ajouterCompte(Request $request)
    {
       
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
    

        $input = $request->all();
        $currentUser = auth()->user();
    
        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->dateNaissance = $input['dateNaissance'];
        $user->adresse = $input['adresse'];
        $user->num = $input['num'];
        $user->usertype = $input['usertype'];
        $user->createdBy = $currentUser->id; 
        $user->email_verified_at = now();
        $user->save();
    
        return redirect()->route('creerCompteForm')->with('success', 'Le compte utilisateur a été créé avec succès.');
    }
    

    public function listeCompte()
{
    $listeComptes = User::whereNotNull('email_verified_at')
                        ->where('status', '1')
                        ->get();

    return view('gestionAdmin.listeCompte', compact('listeComptes'));
}

public function supprimerCompte($id)
{
  
    $user = User::findOrFail($id);

    $user->update([
        'status' => 0,
        'dateSuppression' => now(), 
        'deletedBy' => Auth::id(), 
    ]);

   
    session()->flash('success', 'Le compte a été supprimé avec succès.');
    return back();
}

public function modifierCompte(Request $request, $id)
{
   
    $user = User::findOrFail($id);

    $user->name = $request->name;
    $user->email = $request->email;
    if (!empty($request->password)) {
        $user->password = Hash::make($request->password);
    }
    $user->dateNaissance = $request->dateNaissance;
    $user->adresse = $request->adresse;
    $user->num = $request->num;
    $user->usertype = $request->usertype;
    $user->dateModification = now();
    $user->modifiedBy = Auth::id();
    

   
    $user->save();

    
    session()->flash('success', 'Le compte a été modifié avec succès.');
    return back();
}

public function afficherComptesInactifs()
{
    
    $listeComptes = User::whereNull('email_verified_at')
                        ->where('status', '1')
                       
                        ->get();

    
    return view('gestionAdmin.compteInactifs', ['listeComptes' => $listeComptes]);
}

public function validerEmail($id)
{
    $user = User::findOrFail($id);
    $user->email_verified_at = now();
    $user->save();

    return redirect()->back()->with('success', 'Email vérifié avec succès.');
}

public function afficherComptesSupprimes()
{
    $listeComptes = User::where('status', '0')->get();

    return view('gestionAdmin.compteSupprimés', ['listeComptes' => $listeComptes]);
}


public function recupererCompte($id)
{
    $user = User::find($id);
    if ($user) {
        $user->status = '1';
        $user->deletedBy = null;
        $user->dateSuppression = null;
        $user->save();

        return redirect()->back()->with('success', 'Compte récupéré avec succès.');
    }

    return redirect()->back()->with('error', 'Compte introuvable.');
}










}
