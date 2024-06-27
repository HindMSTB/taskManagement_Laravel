<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Http\Controllers\LoginController; 
use App\Http\Controllers\GestionTachesController;
use App\Http\Controllers\GestionComptesController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Mail;
use App\Mail\HelloMail;
use App\Http\Middleware\CheckUserType;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login'); 
});







Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    Auth::logout(); 
    return redirect('/login')->with('message', 'Votre compte a été vérifié.');
})->middleware(['signed'])->name('verification.verify');

Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Le lien de vérification a été renvoyé !');
})->middleware(['throttle:6,1'])->name('verification.resend');


// apres authentification comme user
Route::middleware(['auth', 'verified', 'check.user_type:user'])->group(function () {

    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
   Route::get('/ajouterTacheForm', [GestionTachesController::class, 'ajouterTacheForm'])->name('ajouterTacheForm');
    Route::post('/ajouterTache', [GestionTachesController::class, 'ajouterTache'])->name('ajouterTache');
    Route::get('/listeTache', [GestionTachesController::class, 'listeTache'])->name('listeTache');
   Route::post('/marquer-terminée/{id}', [GestionTachesController::class, 'marquerTerminée'])->name('marquerTerminée');
   Route::get('/showProfile', [LoginController::class, 'showProfile'])->name('showProfile');
    Route::get('/listeTacheDemmandée', [GestionTachesController::class, 'listeTacheDemmandée'])->name('listeTacheDemmandée');
    Route::post('/markAllNotificationsAsRead', [NotificationController::class, 'markAllAsRead'])->name('markAllNotificationsAsRead');

});

Route::middleware(['auth','verified',  'check.user_type:admin'])->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/dashboard', [LoginController::class, 'adminDashboard'])->name('adminDashboard');
    Route::get('/listeToutesTacheA', [GestionTachesController::class, 'listeToutesTacheA'])->name('listeToutesTacheA');
    Route::get('/showProfileA', [LoginController::class, 'showProfileA'])->name('showProfileA');
    Route::put('/modifierTache/{id}', [GestionTachesController::class, 'modifierTache'])->name('modifierTache');
 
    Route::get('/creerTacheFormA', [GestionTachesController::class, 'creerTacheFormA'])->name('creerTacheFormA');
    Route::post('/ajouterTacheM', [GestionTachesController::class, 'ajouterTacheM'])->name('ajouterTacheM');
    Route::get('/creerCompteForm', [GestionComptesController::class, 'creerCompteForm'])->name('creerCompteForm');
    Route::post('/ajouterCompte', [GestionComptesController::class, 'ajouterCompte'])->name('ajouterCompte');
    Route::get('/listeCompte', [GestionComptesController::class, 'listeCompte'])->name('listeCompte');
    Route::delete('/supprimerCompte/{id}', [GestionComptesController::class, 'supprimerCompte'])->name('supprimerCompte');
    Route::put('/modifierCompte/{id}', [GestionComptesController::class, 'modifierCompte'])->name('modifierCompte');
    Route::get('/comptes-inactifs', [GestionComptesController::class, 'afficherComptesInactifs'])->name('comptesInactifs');
    Route::get('/compteSupprimés', [GestionComptesController::class, 'afficherComptesSupprimes'])->name('compteSupprimés');
    Route::post('/valider-email/{id}', [GestionComptesController::class, 'validerEmail'])->name('validerEmail');
    Route::post('/recuperer-compte/{id}', [GestionComptesController::class, 'recupererCompte'])->name('recupererCompte');
    Route::get('/taches-supprimees', [GestionTachesController::class, 'afficherTachesSupprimes'])->name('listetacheSupprimées');
    Route::post('/recuperer-tache/{id}', [GestionTachesController::class, 'recupererTache'])->name('tache.recuperer');
   
}); 


// apres authentification comme moderateur 
Route::middleware(['auth', 'verified', 'check.user_type:moderateur'])->group(function () {
   
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::get('/moderateur/dashboard', [LoginController::class, 'moderateurDashboard'])->name('moderateurDashboard');
    Route::get('/listeToutesTache', [GestionTachesController::class, 'listeToutesTache'])->name('listeToutesTache');
    Route::delete('/supprimerTache/{id}', [GestionTachesController::class, 'supprimerTache'])->name('supprimerTache');
    Route::put('/modifierTache/{id}', [GestionTachesController::class, 'modifierTache'])->name('modifierTache');
    Route::get('/showProfileM', [LoginController::class, 'showProfileM'])->name('showProfileM');
    Route::post('/affecterTacheModal/{id}', [GestionTachesController::class, 'affecterTacheModal'])->name('affecterTacheModal');
    Route::post('/marquer-terminée/{id}', [GestionTachesController::class, 'marquerTerminée'])->name('marquerTerminée');

    Route::get('/creerTacheForm', [GestionTachesController::class, 'creerTacheForm'])->name('creerTacheForm');
    Route::post('/ajouterTacheM', [GestionTachesController::class, 'ajouterTacheM'])->name('ajouterTacheM');
    Route::put('/modifierTacheF/{id}', [GestionTachesController::class, 'modifierTacheF'])->name('modifierTacheF');
 
});


Route::middleware('auth', 'verified')->group(function () { 
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::post('/ajouterTacheM', [GestionTachesController::class, 'ajouterTacheM'])->name('ajouterTacheM');
    Route::delete('/supprimerTache/{id}', [GestionTachesController::class, 'supprimerTache'])->name('supprimerTache');
    Route::put('/modifierTache/{id}', [GestionTachesController::class, 'modifierTache'])->name('modifierTache');
    Route::post('/marquer-terminée/{id}', [GestionTachesController::class, 'marquerTerminée'])->name('marquerTerminée');
    Route::put('/modifierTacheF/{id}', [GestionTachesController::class, 'modifierTacheF'])->name('modifierTacheF');
 
    Route::post('/affecterTacheModal/{id}', [GestionTachesController::class, 'affecterTacheModal'])->name('affecterTacheModal');

  
    Route::post('/mark-notification-as-read/{id}', [NotificationController::class, 'markNotificationAsRead'])
    ->name('markNotificationAsRead');

      Route::post('/markAllNotificationsAsRead', [NotificationController::class, 'markAllAsRead'])->name('markAllNotificationsAsRead');
});


Route::get('/test-email', function () {
  Mail::to('hindmountainbillah@gmail.com')
        ->send(new HelloMail());
 

});

// Route::view('/inactive-account-error', 'inactiveAccountError')->name('inactiveAccountError');
