<?php

namespace App\Http\Controllers\Consommateur;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;

class CommercantController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'Commercant');
        
        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        
        $commercants = $query->paginate(10);
        
        return view('consommateur.commercant.index', compact('commercants'));
    }
    
    public function show($id)
    {
        $commercant = User::where('role', 'Commercant')->findOrFail($id);
        $produits = Property::where('user_id', $commercant->id)->paginate(8);
        
        // Vérifier si le consommateur suit déjà ce commerçant
        $estSuivi = auth()->user()->commercantsSuivis()->where('commercant_id', $commercant->id)->exists();
        
        return view('consommateur.commercant.show', compact('commercant', 'produits', 'estSuivi'));
    }
    
    public function suivre($id)
    {
        $commercant = User::where('role', 'Commercant')->findOrFail($id);
        auth()->user()->commercantsSuivis()->attach($commercant->id);
        
        return redirect()->back()->with('success', 'Vous suivez maintenant ce commerçant.');
    }
    
    public function nePlusSuivre($id)
    {
        $commercant = User::where('role', 'Commercant')->findOrFail($id);
        auth()->user()->commercantsSuivis()->detach($commercant->id);
        
        return redirect()->back()->with('success', 'Vous ne suivez plus ce commerçant.');
    }
    
    public function suivis()
    {
        $commercantsSuivis = auth()->user()->commercantsSuivis()->paginate(10);
        
        return view('consommateur.commercant.suivis', compact('commercantsSuivis'));
    }
}