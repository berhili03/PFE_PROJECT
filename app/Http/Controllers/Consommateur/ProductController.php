<?php
namespace App\Http\Controllers\Consommateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Comment;
use App\Models\ProduitAime;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $produits = Property::orderBy('created_at', 'desc')->paginate(12);
        
        return view('consommateur.products.index', compact('produits'));
    }

    public function show($id)
    {
        $produit = Property::withCount('likedBy as aimes_count')->findOrFail($id);
        
        $commentaires = Comment::where('product_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $estAime = Auth::check() ? Auth::user()->aime($id) : false;
        
        return view('consommateur.products.show', compact('produit', 'commentaires', 'estAime'));
    }

    public function addComment($id, Request $request)
    {
        $request->validate([
            'contenu' => 'required|string|max:255',
        ]);
        
        $product = Property::findOrFail($id);
        
        $comment = new Comment();
        $comment->contenu = $request->input('contenu');
        $comment->user_id = Auth::id();
        $comment->product_id = $product->id;
        $comment->save();
        
        return back()->with('success', 'Votre commentaire a été ajouté avec succès.');
    }

    public function like($id)
{
    $produit = Property::findOrFail($id);
    
    // Vérifier si l'utilisateur n'a pas déjà aimé ce produit
    if (!auth()->user()->aime($id)) {
        auth()->user()->likes()->attach($produit->id);
    }
    
    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'count' => $produit->fresh()->likedBy()->count()
        ]);
    }
    
    return back();
}

public function unlike($id)
{
    $produit = Property::findOrFail($id);
    
    auth()->user()->likes()->detach($produit->id);
    
    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'count' => $produit->fresh()->likedBy()->count()
        ]);
    }
    
    return back();
}
}