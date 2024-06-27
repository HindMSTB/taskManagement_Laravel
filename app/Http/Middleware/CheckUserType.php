<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle(Request $request, Closure $next, ...$types)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->usertype, $types)) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
