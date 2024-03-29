<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'thumbnail',
        'name',
        'price',
        'hpp',
        'id_user',
        'is_promo',
        'price_promo',
        'status',
    ];
}
