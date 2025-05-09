<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomProduit',
        'description',
        'prix',
        'marque',
        'image',
        'category_name',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_name', 'name');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }
    
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes', 'produit_id', 'user_id');
    }

    protected static function booted()
    {
        static::creating(function ($property) {
            if (auth()->check()) {
                $property->user_id = auth()->id();
            }
        });
    }
}