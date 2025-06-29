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

    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'wishlists');
    }

    // Helper method to update stock with history
    public function updateStock($quantity, $type = 'adjustment', $notes = null, $reference = null)
    {
        $previousStock = $this->stock;
        
        if ($type === 'in') {
            $this->stock += $quantity;
        } elseif ($type === 'out') {
            $this->stock -= $quantity;
        } else {
            $this->stock += $quantity;
        }
        
        $this->save();

        // Create stock history
        StockHistory::create([
            'product_id' => $this->id,
            'type' => $type,
            'quantity' => $quantity,
            'previous_stock' => $previousStock,
            'new_stock' => $this->stock,
            'notes' => $notes,
            'reference' => $reference
        ]);

        return $this;
    }

    // Helper method to check if stock is low
    public function getIsLowStockAttribute()
    {
        return $this->stock <= 10;
    }

    // Helper method to get stock status
    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return 'Habis';
        } elseif ($this->stock <= 10) {
            return 'Stok Menipis';
        } else {
            return 'Tersedia';
        }
    }
}
