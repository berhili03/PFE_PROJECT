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
       
        //dd($request->all()); // Affiche toutes les données envoyées

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dateNaissance' => ['required','date'],
            'sexe' => ['required','string','in:Femme,Homme'],
            'role' => ['required', 'in:Consommateur,Commercant'],
            'tel' => ['required','string'],
            'adresse' => ['required','string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'dateNaissance' => $request->dateNaissance,
            'sexe' => $request->sexe,
            'role' => $request->role,
            'tel' => $request->tel,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

      

        event(new Registered($user));

        Auth::login($user);

        return redirect($this->redirectTo($user));
    }



}
