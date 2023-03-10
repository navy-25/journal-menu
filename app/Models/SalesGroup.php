<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date',
        'id_user',
        'time',
        'note',
    ];
}
