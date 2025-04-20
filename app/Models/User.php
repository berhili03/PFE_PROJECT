<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomResetPassword;





class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'dateNaissance',
        'adresse',
        'tel',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
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

}
