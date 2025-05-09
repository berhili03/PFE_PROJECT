<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;


class Category extends Model
{
    use HasFactory;
    //public $timestamps = false; // Désactive les timestamps automatiques

    protected $fillable = [
      'name',
      'color',
      'icon',
      'image',
      'description'
  ];
  /*Obtenir les produits associés à cette catégorie
  */
    public function products()
    {
        return $this->hasMany(Property::class);
    }

    public function getProductCountAttribute()
    {
        return $this->products()->count();
    }
    
  // 🔁 Relation avec Property (une catégorie a plusieurs produits)
public function properties ()
{
    return $this->hasMany(Property::class);
}
}