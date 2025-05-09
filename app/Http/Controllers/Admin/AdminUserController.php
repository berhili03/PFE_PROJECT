<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    protected $colorPalettes;
    
    public function __construct()
    {
        $this->colorPalettes = [
            ['from' => '#3b82f6', 'to' => '#8b5cf6'],  // Bleu -> Violet
            ['from' => '#10b981', 'to' => '#059669'],  // Vert
            ['from' => '#ec4899', 'to' => '#db2777'],  // Rose
            ['from' => '#f59e0b', 'to' => '#d97706'],  // Orange
            ['from' => '#6366f1', 'to' => '#4f46e5']   // Indigo
        ];
    }

    /**
     * Affiche tous les utilisateurs
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Recherche par nom ou email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filtrage par rôle
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }
        
        $users = $query->paginate(10);
        
        return view('admin.users.index', [
            'users' => $users,
            'colorPalettes' => $this->colorPalettes
        ]);
    }
    
    /**
     * Affiche uniquement les commerçants
     */
    public function commercants(Request $request)
    {
        $query = User::where('role', 'Commercant');
        
        // Recherche par nom ou email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('store_name', 'like', "%{$search}%");
            });
        }
        
        $users = $query->paginate(10);
        
        return view('admin.users.commercants', [
            'users' => $users,
            'colorPalettes' => $this->colorPalettes
        ]);
    }
    
    /**
     * Affiche uniquement les consommateurs
     */
    public function consommateurs(Request $request)
    {
        $query = User::where('role', 'Consommateur');
        
        // Recherche par nom ou email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->paginate(10);
        
        return view('admin.users.consommateurs', [
            'users' => $users,
            'colorPalettes' => $this->colorPalettes
        ]);
    }

    /**
     * Formulaire de création d'un utilisateur
     */
    public function create()
    {
        return view('admin.users.create');
    }



    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'colorPalettes' => $this->colorPalettes
        ]);
    }
    public function update(Request $request, User $user)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
            'role' => 'required|in:admin,Commercant,Consommateur',
            'dateNaissance' => 'nullable|date',
            'adresse' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:20',
        ]);
    

        // Mise à jour des champs
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->adresse = $validated['adresse'];
        $user->tel = $validated['tel'];
    
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
    
        $user->save();
    
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
{
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
}

    /**
     * Enregistre un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:admin,Commercant,Consommateur'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'tel' => ['nullable', 'string', 'max:20'],
        ];
        
        // Validation spécifique pour les commerçants
        if ($request->input('role') === 'Commercant') {
            $rules['store_name'] = ['nullable', 'string', 'max:255'];
            $rules['description'] = ['nullable', 'string'];
        }

        $request->validate($rules);

        // Préparer les données de base
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'dateNaissance' => $request->dateNaissance,
            'adresse' => $request->adresse,
            'tel' => $request->tel,
        ];
        
        // Ajouter les champs spécifiques aux commerçants si nécessaire
        if ($request->role === 'Commercant') {
            $userData['store_name'] = $request->store_name;
            $userData['description'] = $request->description;
        }

        $user = User::create($userData);

        // Redirection en fonction du rôle
        if ($request->role === 'Commercant') {
            return redirect()->route('admin.users.commercants')->with('success', 'Compte commerçant créé avec succès.');
        } elseif ($request->role === 'Consommateur') {
            return redirect()->route('admin.users.consommateurs')->with('success', 'Compte consommateur créé avec succès.');
        } else {
            return redirect()->route('admin.users.index')->with('success', 'Compte administrateur créé avec succès.');
        }
    }}