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
        'category_name', // important si tu l'utilises
    ];

public function category ()
{
    return $this->belongsTo(Category::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}


public function properties()
{
    return $this->hasMany(Property::class);
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
