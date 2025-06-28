<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'unit', 'min_increment', 'image', 'stock', 'featured'
    ];
    
    protected $casts = [
    'featured' => 'boolean',
    'min_increment' => 'decimal:2',
    ];

}