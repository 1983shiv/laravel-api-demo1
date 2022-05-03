<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // if you want to rename your product table to something else in db
    // protected $table = 'my_products';

    protected $fillable = [
        'name',
        'slug',
        'desc',
        'price'
    ];
}
