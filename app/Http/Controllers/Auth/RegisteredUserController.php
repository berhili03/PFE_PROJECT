<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }




    protected function redirectTo($user)
    {
        switch ($user->role) {
            case 'admin':
                return '/admin/dashboard';
            case 'Consommateur':
                return '/consommateur/dashboard';
            case 'Commercant':
                return '/commercant/dashboard';
            default:
                return '/dashboard';
        }
    }
    
  



    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Règles de validation conditionnelles pour le nom de la boutique
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'sexe' => ['required', 'string', 'in:Femme,Homme'],
            'role' => ['required', 'in:Consommateur,Commercant'],
            'tel' => ['required', 'string'],
            'adresse' => ['required', 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
        
        // Ajouter la validation du nom de la boutique si le rôle est Commercant
        if ($request->role === 'Commercant') {
            $rules['nom_boutique'] = ['required', 'string', 'max:255'];
        }
        
        $request->validate($rules);
        
        // Construction des données pour la création de l'utilisateur
        $userData = [
            'name' => $request->name,
            'sexe' => $request->sexe,
            'role' => $request->role,
            'tel' => $request->tel,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];
        
        // Ajouter le nom de la boutique uniquement si le rôle est Commercant
        if ($request->role === 'Commercant') {
            $userData['store_name'] = $request->store_name;
        }
        
        $user = User::create($userData);
        
        event(new Registered($user));
        
        Auth::login($user);
        
        return redirect($this->redirectTo($user));
    }



}
