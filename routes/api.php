<?php 

use App\Models\Item;
use Illuminate\Support\Facades\Route;

Route::get('/items', function () {
    return Item::all();
});