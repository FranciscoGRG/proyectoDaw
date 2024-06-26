<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class create_clothes_table extends Model
{
    protected $fillable = [
        'nombre', 'genero', 'tipo', 'largo', 'color', 'precio', 'img', 'url'
    ];
    
    use HasFactory;

}
