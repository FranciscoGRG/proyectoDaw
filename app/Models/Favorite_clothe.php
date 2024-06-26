<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite_clothe extends Model
{
    use HasFactory;

    protected $fillable = [
        'camiseta', 'pantalon', 'zapatos', 'creador', 'outit_id'
    ];

    protected $casts = [
        'camiseta' => 'array',
        'pantalon' => 'array',
        'zapatos' => 'array',
    ];

    //Realcion muchos a muchos
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
