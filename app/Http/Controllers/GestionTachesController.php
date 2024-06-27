<?php

namespace App\Http\Controllers;
use App\Models\Notification;

use Illuminate\Http\Request;
use App\Models\Tache;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;  


class GestionTachesController extends Controller
{
    public function ajouterTacheForm()
    {
        return view('gestionTaches.ajouterTacheForm');
    }

   
    public function ajouterTache(Request $request)
    {
       
        $request->validate([
            'titre' => 'required|string',
            'description' => 'required|string',
            'dateDue' => 'required|date',
            'priorite' => 'required|string',
        ]);
   
        $currentUser = Auth::user();
    
      
        $tache = new Tache([
            'titre' => $request->titre,
            'description' => $request->description,
            'dateDue' => $request->dateDue,
            'priorite' => $request->priorite,
            'createdBy' => $currentUser->id, 
          
        ]);
    
       
        $tache->save();
    
         $tache->update(['tacheOrig' => $tache->id]);

         Notification::create([
            'contenu' => 'Nouvelle ticket ajouté : ' . $tache->titre,
            'type' => 'ajout',
            'tache_id' => $tache->id,
        ]);
    
 
         return back()->with('success', 'Le ticket a été ajouté avec succès.');
    }
    
  
    public function creerTacheForm()
    {
        $users = User::all();
    
        return view('Moderateur.creerTacheForm', compact('users'));
     
    }

   

    public function creerTacheFormA()
    {
        $users = User::all();
    
        return view('gestionAdmin.creerTacheFormA', compact('users'));
     
    }

public function ajouterTacheM(Request $request)
{
   
    $currentUser = auth()->user();

  
    $validatedData = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'dateDue' => 'required|date',
        'priorite' => 'required|in:faible,moyenne,forte',
        'user_id' => 'nullable|exists:users,id', 
    ]);

    
    $tache = new Tache();
    $tache->titre = $validatedData['titre'];
    $tache->description = $validatedData['description'];
    $tache->dateDue = $validatedData['dateDue'];
    $tache->priorite = $validatedData['priorite'];
    $tache->user_id = $validatedData['user_id']; 

    if ($tache->user_id !== null) {
        $tache->dateAffectation = now(); 
    }
    
    $tache->etat = 'en cours';
    $tache->createdBy = $currentUser->id; 
    $tache->save();
    $tache->update(['tacheOrig' => $tache->id]);
  
    return redirect()->back()->with('success', 'La tâche a été ajoutée avec succès.');
}




    public function listeTache()
    {
       
        $user = Auth::user();
       
        $toutesLesTaches = Tache::where('user_id', $user->id)
                                 ->where('status', 1)
                                 ->get();
        
        $tachesEnCours = $toutesLesTaches->where('etat', 'en cours');
      
        $tachesTerminees = $toutesLesTaches->where('etat', 'terminée');
    
      
        return view('gestionTaches.listeTache', [
            'toutesLesTaches' => $toutesLesTaches,
            'tachesEnCours' => $tachesEnCours,
            'tachesTerminees' => $tachesTerminees,
           
        ]);
    }
    
       
    public function listeTacheDemmandée()
    {
        $user = Auth::user();
        
      
        $toutesLesTaches = Tache::where('createdBy', $user->id)
                                 ->where('status', 1)
                                 ->get();
        
       
        $tachesEnCours = $toutesLesTaches->where('etat', 'en cours');
        
       
        $tachesTerminees = $toutesLesTaches->where('etat', 'terminée');
    
       
        return view('gestionTaches.listeTacheDemmandée', [
            'toutesLesTaches' => $toutesLesTaches,
            'tachesEnCours' => $tachesEnCours,
            'tachesTerminees' => $tachesTerminees,
           
        ]);
    }
    

    public function marquerTerminée(Request $request, $id)
{
  
    $request->validate([
        'message' => 'required|string',
    ]);

    $tache = Tache::findOrFail($id);

    $tache->update([
        'etat' => 'terminée',
        'DateFin' => now(),
        'messageFin' => $request->message,
    ]);

    Notification::create([
        'contenu' => 'Votre ticket "' . $tache->titre . '" a été terminée.',
        'type' => 'terminée',
        'tache_id' => $tache->id,
       
    ]);

    session()->flash('success', 'La tâche a été marquée comme terminée avec succès.');

    return back();
}



    public function listeToutesTache()
    {
        $toutesLesTaches = Tache::where('status', 1)->get();
       
        $tachesEnCours = $toutesLesTaches->where('etat', 'en cours')
                                         ->whereNotNull('user_id');
                                         
        $tachesNonAffectees = $toutesLesTaches ->where('etat', 'en cours')
                                               ->whereNull('user_id');

        $tachesTerminees = $toutesLesTaches->where('etat', 'terminée');
    
        return view('Moderateur.listeToutesTache', [
            'toutesLesTaches' => $toutesLesTaches,
            'tachesNonAffectees' => $tachesNonAffectees,
            'tachesEnCours' => $tachesEnCours,
            'tachesTerminees' => $tachesTerminees,
        ]);
    }

    public function listeToutesTacheA()
    {
        $toutesLesTaches = Tache::where('status', 1)->get();
       
        $tachesEnCours = $toutesLesTaches->where('etat', 'en cours')
                                         ->whereNotNull('user_id');
                                         
        $tachesNonAffectees = $toutesLesTaches ->where('etat', 'en cours')
                                               ->whereNull('user_id');

        $tachesTerminees = $toutesLesTaches->where('etat', 'terminée');
    
        return view('gestionAdmin.listeToutesTacheA', [
            'toutesLesTaches' => $toutesLesTaches,
            'tachesNonAffectees' => $tachesNonAffectees,
            'tachesEnCours' => $tachesEnCours,
            'tachesTerminees' => $tachesTerminees,
        ]);
    }
    
    
    

    public function supprimerTache($id)
    {
      
        $tache = Tache::findOrFail($id);
    
    $tache->update([
            'status' => 0,
            'dateSuppression' => now(), 
            'deletedBy' => Auth::id(), 
        ]);
    
       
        session()->flash('success', 'La tâche a été supprimée avec succès.');
        return back();
    }
    
    
  
    public function modifierTache(Request $request, $id)
    {
        $tache = Tache::findOrFail($id);
    
        $donneesTache = [
            'titre' => $request->titre,
            'description' => $request->description,
            'dateDue' => $request->dateDue,
            'DateFin' => $request->DateFin,
            'priorite' => $request->priorite,
            'createdBy' => $tache->createdBy,
            'etat' => $tache->etat,
            'tacheOrig' => $tache->tacheOrig,
            'dateAffectation' => $tache->dateAffectation,
            'user_id' => $request->user_id ?: null,
        ];
        $nouvelleTache = new Tache($donneesTache);

        // Comparaison des champs et création du texte de modification
        $detailsModification = [];
        foreach ($donneesTache as $champ => $valeur) {
            if ($tache->$champ != $valeur) {
                if ($champ == 'user_id') {
                    $ancienUser = User::find($tache->$champ);
                    $nouveauUser = User::find($valeur);
                    $ancienUserName = $ancienUser ? $ancienUser->name : 'Utilisateur inconnu';
                    $nouveauUserName = $nouveauUser ? $nouveauUser->name : 'Utilisateur inconnu';
                    $detailsModification[] = " modifictaion d'affectation  de \"$ancienUserName\" à \"$nouveauUserName\"";
                } else {
                    $detailsModification[] = "modification de $champ de \"{$tache->$champ}\" à \"$valeur\"";
                }
            }
        }
    
        if ($tache->user_id != $request->user_id) {
            $donneesTache['dateAffectation'] = now();
        }
    
        // Mise à jour de la tâche
        $nouvelleTache = new Tache($donneesTache);
        $nouvelleTache->save();
    
        // Ajout des détails de modification
        $tache->update([
            'status' => 0,
            'dateModification' => now(),
            'modifiedBy' => Auth::id(),
            'ModifDetails' => implode(', ', $detailsModification),
        ]);
    
        return back()->with('success', 'La tâche a été modifiée avec succès.');
    }
    
    public function modifierTacheF(Request $request, $id)
    {
        $tache = Tache::findOrFail($id);
    
        $donneesTache = [
            'titre' => $request->titre,
            'description' => $request->description,
            'dateDue' => $request->dateDue,
            'DateFin' => $request->DateFin,
            'priorite' => $request->priorite,
            'createdBy' => $tache->createdBy,
            'etat' => $tache->etat,
            'tacheOrig' => $tache->tacheOrig,
            'messageFin' => $request->messageFin,
            'user_id' => $tache->user_id,
            'dateAffectation' => $tache->dateAffectation,
        ];
    
       
        $detailsModification = [];
        foreach ($donneesTache as $champ => $valeur) {
            if ($tache->$champ != $valeur) {
                if ($champ == 'user_id') {
                    $ancienUser = User::find($tache->$champ);
                    $nouveauUser = User::find($valeur);
                    $ancienUserName = $ancienUser ? $ancienUser->name : 'Utilisateur inconnu';
                    $nouveauUserName = $nouveauUser ? $nouveauUser->name : 'Utilisateur inconnu';
                    $detailsModification[] = "modification d'affectation de \"$ancienUserName\" à \"$nouveauUserName\"";
                } else {
                    $detailsModification[] = "modification de $champ de \"{$tache->$champ}\" à \"$valeur\"";
                }
            }
        }
    
        $nouvelleTache = new Tache($donneesTache);
        $nouvelleTache->save();

    
    
        // Ajout des détails de modification
        $tache->update([
            'status' => 0,
            'dateModification' => now(),
            'modifiedBy' => Auth::id(),
            'ModifDetails' => implode(', ', $detailsModification),
        ]);
    
        return back()->with('success', 'La tâche a été modifiée avec succès.');
    }
   
   
    public function affecterTacheModal(Request $request, $tache_id)
    {
        $tache = Tache::findOrFail($tache_id);
        $user_id = $request->input('user_id');
    
        $user = User::find($user_id);
    
        if (!$user) {
            
            return back()->with('error', 'L\'utilisateur sélectionné n\'existe pas.');
        }
    
       
        $tache->user_id = $user_id;
        $tache->dateAffectation =now();
        $tache->save();

         Notification::create([
        'contenu' => 'Une nouvelle tâche vous a été affectée : ' . $tache->titre,
        'type' => 'affectation',
        'tache_id' => $tache->id,
      
    ]);

        Notification::create([
            'contenu' => 'Votre tâche "' . $tache->titre . '" a été affectée.',
            'type' => 'createdAff',
            'tache_id' => $tache->id,
          
        ]);
    
        return back()->with('success', 'La tâche a été affectée avec succès.');
   }



   public function afficherTachesSupprimes()
{
    $listeTaches = Tache::where('status', '0')
    ->whereNotNull('deletedBy')
    ->get();


    return view('gestionAdmin.tacheSupprimées', ['tacheSupprimées' =>   $listeTaches]);
}

public function recupererTache($id)
{
    $tache = Tache::findOrFail($id);
    $tache->status = 1;
    $tache->save();

    return redirect()->back()->with('success', 'Tâche récupérée avec succès.');
}


public function detailsPage($id)
{
  
    $tache = Tache::findOrFail($id);

  
    $createurId = $tache->createdBy;
    $createur = User::findOrFail($createurId);
    $createurName= $createur->name;
    // Calculer la période depuis la création de la tâche
    // $periodeCreation = $tache->dateCreation->diffForHumans();

    // // Calculer la période restante avant la date d'échéance
    // $periodeRestante = now()->diffInDays($tache->dateDue) . ' jours';

    // Passer les données à la vue de détails de la tâche
    return view('gestionTaches.detailsPage', [
        'tache' => $tache,
        'createurName' => $createurName,
     
    ]);
}









}
