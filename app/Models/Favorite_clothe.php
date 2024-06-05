<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite_clothe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'precio', 'imagen', 'URL'
    ];

    //Realcion muchos a muchos
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
