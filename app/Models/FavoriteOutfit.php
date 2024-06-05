<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteOutfit extends Model
{
    use HasFactory;

    protected $fillable = ['camiseta', 'pantalon', 'zapatos', 'likes', 'user_id'];

    protected $casts = [
        'camiseta' => 'array',
        'pantalon' => 'array',
        'zapatos' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
