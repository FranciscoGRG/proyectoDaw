<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteOutfit extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'footwear', 'trousers', 'Tshirt', 'coat', 'complements', 'images', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

