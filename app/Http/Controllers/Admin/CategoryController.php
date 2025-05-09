<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all()->map(function ($category) {
            $category->products_count = Property::where('category_name', $category->name)->count();
            return $category;
        });

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'color' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $validated['image'] = $path;
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie ajoutée avec succès!');
    }

    /**
     * Display the specified category and its products.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        // Récupérer les produits avec pagination pour maintenir la pagination
        $products = Property::where('category_name', $category->name)
            ->with('user')
            ->paginate(12);

        // Récupérer tous les produits pour le regroupement (sans pagination)
        $allProducts = Property::where('category_name', $category->name)
            ->with('user')
            ->get();

        // Regrouper les produits par commerçant (user_id)
        $groupedProducts = $allProducts->groupBy('user_id');

        return view('admin.categories.show', compact('category', 'products', 'groupedProducts'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    
     public function update(Request $request, Category $category)
     {
         $validated = $request->validate([
             'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
             'color' => 'nullable|string|max:255',
             'icon' => 'nullable|string|max:255',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
 
         // Sauvegarder l'ancien nom pour mettre à jour les références
         $oldName = $category->name;
         $newName = $validated['name'];
 
         if ($request->hasFile('image')) {
             // Supprimer l'ancienne image si elle existe
             if ($category->image) {
                 Storage::disk('public')->delete($category->image);
             }
             $path = $request->file('image')->store('categories', 'public');
             $validated['image'] = $path;
         }
 
         // Pour éviter la violation de contrainte d'intégrité, on utilise une transaction
         // et on désactive temporairement les vérifications de clés étrangères
         DB::beginTransaction();
         try {
             // Désactiver temporairement la vérification des clés étrangères
             DB::statement('SET FOREIGN_KEY_CHECKS=0');
             
             // Mettre à jour la catégorie
             $category->update($validated);
             
             // Si le nom a changé, mettre à jour tous les produits utilisant cette catégorie
             if ($oldName !== $newName) {
                 Property::where('category_name', $oldName)->update(['category_name' => $newName]);
             }
             
             // Réactiver la vérification des clés étrangères
             DB::statement('SET FOREIGN_KEY_CHECKS=1');
             
             // Valider la transaction
             DB::commit();
         } catch (\Exception $e) {
             // En cas d'erreur, annuler la transaction et réactiver les vérifications
             DB::rollBack();
             DB::statement('SET FOREIGN_KEY_CHECKS=1');
             
             // Relancer l'exception pour afficher l'erreur
             throw $e;
         }
 
         return redirect()->route('admin.categories.index')
             ->with('success', 'Catégorie mise à jour avec succès!');
     }

    /**
     * Show the confirmation form for deleting the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Category $category)
    {
        $productsCount = Property::where('category_name', $category->name)->count();
        return view('admin.categories.delete', compact('category', 'productsCount'));
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Mettre à jour les produits de cette catégorie pour qu'ils n'aient plus de catégorie
        Property::where('category_name', $category->name)
            ->update(['category_name' => null]);

        // Supprimer l'image si elle existe
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès!');
    }
}