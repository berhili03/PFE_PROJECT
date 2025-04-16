<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;

class AdminController extends Controller
{
    public function index()
    {
        // Compter les commerçants 
        $commercantCount = User::where('role', 'commercant')->count();

        // Compter les consommateurs (par exemple, role = 'user' ou 'consumer')
        $consommateurCount = User::where('role', 'consommateur')->count();

        // Compter les produits
        $produitCount = Property::count();

        return view('admin.dashboard', compact('commercantCount', 'consommateurCount', 'produitCount'));
    }
}
