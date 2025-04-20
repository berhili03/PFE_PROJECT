<?php

namespace App\Http\Controllers\Consommateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property; // Assurez-vous d'importer votre modèle de produit

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Property::findOrFail($id);
        return view('consommateur.products.show', compact('product'));
    }
}