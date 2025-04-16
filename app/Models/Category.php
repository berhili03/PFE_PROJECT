<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;


class Category extends Model
{
    use HasFactory;
    //public $timestamps = false; // Désactive les timestamps automatiques

    protected $fillable = ['name']; // Permet l'ajout de la colonne "name"

    
  // 🔁 Relation avec Property (une catégorie a plusieurs produits)
public function properties ()
{
    return $this->hasMany(Property::class);
}
}