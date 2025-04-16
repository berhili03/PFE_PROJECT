<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    
    
        // Méthode pour afficher le formulaire d'édition du profil de l'admin
        public function editAdmin()
        {
            // Récupérer l'utilisateur connecté
            $user = auth()->user();
            
            // Retourner la vue d'édition spécifique à l'admin
            return view('profile.admin.edit', compact('user'));
        }
    
        // Méthode pour afficher le formulaire d'édition du profil du commerçant
        public function editCommercant()
        {
            // Récupérer l'utilisateur connecté
            $user = auth()->user();
            
            // Retourner la vue d'édition spécifique au commerçant
            return view('profile.commercant.edit', compact('user'));
        }
    
        // Méthode pour afficher le formulaire d'édition du profil du consommateur
        public function editConsommateur()
        {
            // Récupérer l'utilisateur connecté
            $user = auth()->user();
            
            // Retourner la vue d'édition spécifique au consommateur
            return view('profile.consommateur.edit', compact('user'));
        }
    
    

    /**
     * Update the user's profile information.
     */
    public function updateAdmin(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->fill($request->validated());
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        $user->save();
    
        return Redirect::route('profile.admin.edit')->with('status', 'profile-updated');
    }
    
    public function updateCommercant(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->fill($request->validated());
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        $user->save();
    
        return Redirect::route('profile.commercant.edit')->with('status', 'profile-updated');
    }
    
    public function updateConsommateur(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->fill($request->validated());
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        $user->save();
    
        return Redirect::route('profile.consommateur.edit')->with('status', 'profile-updated');
    }
    

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

  // Afficher le profil du commerçant
    public function showCommercant()
    {
        $user = auth()->user();
        return view('profile.commercant.show', compact('user'));
    }

    // Afficher le profil de l'admin
    public function showAdmin()
    {
        $user = auth()->user();
        return view('profile.admin.show', compact('user'));
    }

    // Afficher le profil du consommateur
    public function showConsommateur()
    {
        $user = auth()->user();
        return view('profile.consommateur.show', compact('user'));
    }


}
