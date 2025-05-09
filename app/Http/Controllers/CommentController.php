<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Stocke un nouveau commentaire.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $produit
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Property $produit)
    {
        $request->validate([
            'contenu' => 'required|string'
        ]);

        $comment = new Comment([
            'contenu' => $request->contenu,
            'user_id' => Auth::id(),
            'product_id' => $produit->id
        ]);

        $comment->save();

        return redirect()->back()->with('success', 'Votre commentaire a été publié avec succès!');
    }

    /**
     * Met à jour le commentaire spécifié.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $commentaire)
    {
        // Vérifier que l'utilisateur connecté est l'auteur du commentaire
        if (Auth::id() !== $commentaire->user_id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier ce commentaire');
        }

        $request->validate([
            'contenu' => 'required|string'
        ]);

        $commentaire->contenu = $request->contenu;
        $commentaire->save();

        return redirect()->back()->with('success', 'Votre commentaire a été mis à jour avec succès');
    }

    /**
     * Supprime le commentaire spécifié.
     *
     * @param  \App\Models\Comment  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $commentaire)
    {
        // Vérifier que l'utilisateur connecté est l'auteur du commentaire
        if (Auth::id() !== $commentaire->user_id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire');
        }

        $commentaire->delete();

        return redirect()->back()->with('success', 'Votre commentaire a été supprimé avec succès');
    }
}