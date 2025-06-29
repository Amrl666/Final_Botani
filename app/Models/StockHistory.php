<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'previous_stock',
        'new_stock',
        'notes',
        'reference'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Stock change types
    public static function getTypes()
    {
        return [
            'in' => 'Stok Masuk',
            'out' => 'Stok Keluar',
            'adjustment' => 'Penyesuaian',
        ];
    }

    // Helper method to get type label
    public function getTypeLabelAttribute()
    {
        return self::getTypes()[$this->type] ?? $this->type;
    }

    // Helper method to get change direction
    public function getIsIncreaseAttribute()
    {
        return $this->type === 'in' || ($this->type === 'adjustment' && $this->quantity > 0);
    }

    // Helper method to get change direction
    public function getIsDecreaseAttribute()
    {
        return $this->type === 'out' || ($this->type === 'adjustment' && $this->quantity < 0);
    }
}
