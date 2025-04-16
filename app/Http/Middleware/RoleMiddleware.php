<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check()) {
            // Vérifie que le rôle de l'utilisateur correspond à celui spécifié
            if (Auth::user()->role === $role) {
                return $next($request);
            }
        }
    
        // Si l'utilisateur n'a pas le bon rôle, retourne une erreur 403
        abort(403, 'Accès interdit');
    }
    
}
