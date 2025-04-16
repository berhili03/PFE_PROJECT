<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    // Assure-toi que l'utilisateur est authentifié avant de supprimer son compte
    public function destroy(Request $request)
    {
        // Vérifier si l'utilisateur est authentifié
        $user = Auth::user();

        // Supprimer l'utilisateur
        $user->delete();

        // Déconnecter l'utilisateur après suppression
        Auth::logout();

        // Rediriger l'utilisateur vers la page d'accueil ou une page de confirmation
        return redirect('/')->with('status', 'Votre compte a été supprimé avec succès.');
    }
}

