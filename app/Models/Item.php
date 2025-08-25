<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'color',
        'fuel',
        'year_model',
        'year_build',
        'photos',
        'sold'
    ];
}
