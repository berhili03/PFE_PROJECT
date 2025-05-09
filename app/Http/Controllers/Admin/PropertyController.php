<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Models\Property;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Query builder for properties
        $query = Property::query()->with('user');

        // Search by product name
        if ($request->filled('search')) {
            $query->where('nomProduit', 'like', '%' . $request->search . '%');
        }

        // Search by merchant/store name
        if ($request->filled('commercant')) {
            // Join with users table to search by merchant name
            $query->whereHas('user', function ($q) use ($request) {
                $q->where(function($subquery) use ($request) {
                    // Search in both name and store_name fields
                    $subquery->where('name', 'like', '%' . $request->commercant . '%')
                            ->orWhere('store_name', 'like', '%' . $request->commercant . '%');
                });
            });
        }

        // Filter by category
        if ($request->filled('categorie')) {
            $query->where('category_name', $request->categorie);
        }

        // Get categories for filter dropdown
        $categories = Property::distinct()->pluck('category_name');

        // Get results with pagination
        $properties = $query->latest()->paginate(10)->withQueryString();

        return view('admin.property.index', compact('properties', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $property = new Property();
        $property->user = auth()->user();
        $categories = Property::distinct()->pluck('category_name', 'category_name');
        
        return view('admin.property.form', compact('property', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PropertyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {
        $property = new Property();
        $property->user_id = auth()->id();
        
        return $this->saveProperty($request, $property);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        $categories = Property::distinct()->pluck('category_name', 'category_name');
        return view('admin.property.form', compact('property', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PropertyRequest  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyRequest $request, Property $property)
    {
        return $this->saveProperty($request, $property);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        // Delete image if exists
        if ($property->image) {
            Storage::delete($property->image);
        }
        
        $property->delete();
        
        return redirect()->route('admin.property.index')
            ->with('success', 'Le produit a été supprimé avec succès.');
    }

    /**
     * Save property data for both create and update.
     *
     * @param  \App\Http\Requests\PropertyRequest  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    private function saveProperty(PropertyRequest $request, Property $property)
    {
        // Handle new category if selected
        $category = $request->categorie;
        if ($category === 'Autre' && $request->filled('new_categorie')) {
            $category = $request->new_categorie;
        }

        // Populate property with form data
        $property->nomProduit = $request->nomProduit;
        $property->description = $request->description;
        $property->marque = $request->marque;
        $property->prix = $request->prix;
        $property->category_name = $category;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($property->exists && $property->image) {
                Storage::delete($property->image);
            }
            
            $property->image = $request->file('image')->store('products', 'public');
        }

        $property->save();

        $action = $property->wasRecentlyCreated ? 'créé' : 'modifié';
        return redirect()->route('admin.property.index')
            ->with('success', "Le produit a été {$action} avec succès.");
    }
    public function show(Property $property)
    {
        $comments = $property->comments()->with('user')->latest()->get(); // on récupère les commentaires liés au produit
        return view('admin.property.show', compact('property', 'comments'));
    }
    
}