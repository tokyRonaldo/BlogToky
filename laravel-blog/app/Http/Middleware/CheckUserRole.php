<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifier le rôle de l'utilisateur
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        // Si l'utilisateur n'a pas le rôle requis, rediriger ou renvoyer une réponse d'erreur
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
