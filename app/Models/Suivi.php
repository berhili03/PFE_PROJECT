<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suivi extends Model
{
    use HasFactory;
    
    protected $table = 'suivis';
    protected $fillable = ['consommateur_id', 'commercant_id'];
    
    public function consommateur()
    {
        return $this->belongsTo(User::class, 'consommateur_id');
    }
    
    public function commercant()
    {
        return $this->belongsTo(User::class, 'commercant_id');
    }
}