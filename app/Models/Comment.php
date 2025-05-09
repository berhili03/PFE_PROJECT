<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = ['contenu', 'user_id', 'product_id'];
    
    public function product()
    {
        return $this->belongsTo(Property::class, 'product_id');
    }
    
    // Renommez cette relation pour qu'elle corresponde à ce que vous utilisez dans votre vue
    public function consommateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // Gardez également la relation user pour la compatibilité
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}