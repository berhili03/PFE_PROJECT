<?php

namespace App\Http\Controllers\Commercant;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Http\Requests\Commercant\PropertyFormRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
    {
        $query = Property::query()->where('user_id', auth()->id());
    
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
    
        // Récupérer les produits filtrés
        $properties = $query->orderBy('created_at', 'desc')->paginate(8)->withQueryString();
    
        // Pour remplir le select des catégories dans la vue
        $categories = Category::pluck('name')->toArray();
    
        return view('commercant.property.index', compact('properties', 'categories'));
    }
    

    public function create()
    {
        $categories = Category::pluck('name', 'name')->toArray();
        $categories['Autre'] = 'Autre';

        return view('commercant.property.form', [
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
            'user_id' => auth()->id(), // 👈 C’est ici qu’on lie le produit au commerçant
        ]);
        

        return redirect()->route('commercant.property.index')
        ->with('success', 'Le produit a été ajouté avec succès');
    }






    public function edit(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce produit.');
        }
    
        $categories = Category::pluck('name', 'name')->toArray();
        $categories['Autre'] = 'Autre';
    
        return view('commercant.property.form', [
            'property' => $property,
            'categories' => $categories
        ]);
    }
    





    public function update(PropertyFormRequest $request, Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce produit.');
        }
    
        $validated = $request->validated();
        $categoryName = $this->handleCategory($request, $validated);
        $imagePath = $this->handleImageUpload($request, $property);
    
        $property->update([
            'nomProduit' => $validated['nomProduit'],
            'description' => $validated['description'],
            'prix' => $validated['prix'],
            'marque' => $validated['marque'],
            'image' => $imagePath,
            'category_name' => $categoryName,
        ]);
    
        return redirect()->route('commercant.property.index')
            ->with('success', 'Le produit a été mis à jour avec succès');
    }
    




    public function destroy(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer ce produit.');
        }
    
        if ($property->image && Storage::exists('public/' . $property->image)) {
            Storage::delete('public/' . $property->image);
        }
    
        $property->delete();
    
        return redirect()->route('commercant.property.index')
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


    public function rules(): array
{
    return [
        'nomProduit' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'prix' => ['required', 'numeric'],
        'marque' => ['required', 'string', 'max:255'],
        'categorie' => ['required', 'string'],
        'new_categorie' => ['nullable', 'string', 'max:255'],
        'image' => ['nullable', 'image', 'max:2048'], // 👈 Ajoute cette ligne ici
    ];
}

}