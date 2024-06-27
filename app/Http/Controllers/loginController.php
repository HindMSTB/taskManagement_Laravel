<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function dashboard(Request $request)
{
    $user = auth()->user();

    if ($user && $user->status === '0') {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('error', 'Votre compte a été supprimé, contactez l\'administrateur.');
    }

    if ($user && $user->usertype === 'admin') {
        return redirect()->route('adminDashboard');
    } elseif ($user && $user->usertype === 'moderateur') {
        return redirect()->route('moderateurDashboard');
    } else {
        return view('dashboard');
    }
}

    public function adminDashboard(Request $request)
    {
        $user = auth()->user();

       
        return view('gestionAdmin.adminDashboard');
    }

    public function moderateurDashboard(Request $request)
    {
        $user = auth()->user();

       
        return view('Moderateur.moderateurDashboard');
    }
    
    public function showProfile()
    {
        return view('profile.show');
    }
    
    public function showProfileM()
    {
        return view('profile.showM');
    }

    public function showProfileA()
    {
        return view('profile.showA');
    }
    
}