<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomResetPassword;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;


    protected $fillable = [
        'name',
        'email',
        'password',
        'adresse',
        'sexe',
        'role',
        'tel',
        'store_name'
    ];
    

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function commercantsSuivis()
    {
        return $this->belongsToMany(
            User::class, 
            'suivis', 
            'consommateur_id', 
            'commercant_id'
        )->withTimestamps();
    }
    
    public function consommateursSuiveurs()
    {
        return $this->belongsToMany(
            User::class, 
            'suivis', 
            'commercant_id', 
            'consommateur_id'
        )->withTimestamps();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function produits()
    {
        return $this->hasMany(Property::class, 'user_id');
    }

    public function likes()
    {
        return $this->belongsToMany(Property::class, 'likes', 'user_id', 'produit_id');
    }

    public function aime($produitId)
    {
        return $this->likes()->where('produit_id', $produitId)->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
}