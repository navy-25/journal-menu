<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_menu',
        'qty',
        'date',
        'sales_group_id',
        'gross_profit',
        'net_profit',
    ];
}
