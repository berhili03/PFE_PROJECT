<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Category;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    /**
     * Affiche les produits d'un commerçant spécifique pour une catégorie.
     *
     * @param  int  $merchantId
     * @param  int  $categoryId
     * @return \Illuminate\Http\Response
     */
    public function showProducts($merchantId, $categoryId)
    {
        $merchant = User::findOrFail($merchantId);
        $category = Category::findOrFail($categoryId);
        
        // Récupérer tous les produits du commerçant dans cette catégorie
        $products = Property::where('user_id', $merchantId)
            ->where('category_name', $category->name)
            ->paginate(12);
            
        return view('admin.merchants.show_products', compact('merchant', 'category', 'products'));
    }
}