<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Http\Requests\Admin\PropertyFormRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class PropertyController extends Controller
{
    public function index()
    {
        $query = Property::query();
    
        // Recherche par nom de produit ou marque
        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomProduit', 'like', "%{$search}%")
                  ->orWhere('marque', 'like', "%{$search}%");
            });
        }
    
        // Filtrage par catégorie
        if (request()->filled('categorie')) {
            $query->where('category_name', request('categorie'));
        }

        // Filtrage par nom du commerçant
        if (request()->filled('commercant')) {
            $commercant = request('commercant');
            $query->whereHas('user', function ($q) use ($commercant) {
                $q->where('name', 'like', "%{$commercant}%");
            });
        }

    
        // Récupérer les produits filtrés
        $properties = $query->with('user')->orderBy('created_at', 'desc')->paginate(8)->withQueryString();
    
        // Pour remplir le select des catégories dans la vue
        $categories = Category::pluck('name')->toArray();
    
        return view('admin.property.index', compact('properties', 'categories'));
    }
    

    public function create()
    {
        $categories = Category::pluck('name', 'name')->toArray();
        $categories['Autre'] = 'Autre';

        return view('admin.property.form', [
            'property' => new Property(),
            'categories' => $categories
        ]);
    }

    public function store(PropertyFormRequest $request)
    {
        $validated = $request->validated();

        // Gestion de l'image
        $imagePath = $this->handleImageUpload($request);

        // Gestion de la catégorie
        $categoryName = $this->handleCategory($request, $validated);

        Property::create([
            'nomProduit' => $validated['nomProduit'],
            'description' => $validated['description'],
            'prix' => $validated['prix'],
            'marque' => $validated['marque'],
            'image' => $imagePath,
            'category_name' => $categoryName,
        ]);

        return redirect()->route('admin.property.index')
            ->with('success', 'Le produit a été ajouté avec succès');
    }




        public function edit(Property $property)
        {
            $categories = Category::pluck('name', 'name')->toArray();
            $categories['Autre'] = 'Autre';

            return view('admin.property.form', [
                'property' => $property,
                'categories' => $categories
            ]);
        }


    public function update(PropertyFormRequest $request, Property $property)
    {
        $validated = $request->validated();

        // Gestion de la catégorie
        $categoryName = $this->handleCategory($request, $validated);

        // Gestion de l'image
        $imagePath = $this->handleImageUpload($request, $property);

        $property->update([
            'nomProduit' => $validated['nomProduit'],
            'description' => $validated['description'],
            'prix' => $validated['prix'],
            'marque' => $validated['marque'],
            'image' => $imagePath,
            'category_name' => $categoryName,
        ]);

        return redirect()->route('admin.property.index')
            ->with('success', 'Le produit a été mis à jour avec succès');
    }

    public function destroy(Property $property)
    {
        // Supprimer l'image associée si elle existe
        if ($property->image && Storage::exists('public/' . $property->image)) {
            Storage::delete('public/' . $property->image);
        }

        $property->delete();

        return redirect()->route('admin.property.index')
            ->with('success', 'Le produit a été supprimé avec succès');
    }

    // Méthodes privées pour factoriser le code
    private function handleImageUpload($request, $property = null)
    {
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($property && $property->image) {
                Storage::delete('public/' . $property->image);
            }
            return $request->file('image')->store('images', 'public');
        }
        
        return $property->image ?? null;
    }

    private function handleCategory($request, $validated)
    {
        if ($validated['categorie'] === 'Autre' && $request->filled('new_categorie')) {
            $newCategory = Category::firstOrCreate(['name' => $request->new_categorie]);
            return $newCategory->name;
        }

        return $validated['categorie'];
    }
}