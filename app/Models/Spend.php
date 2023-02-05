<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spend extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'price',
        'note',
        'date',
        'image',
    ];
}
