<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'unit', 'min_increment', 'image', 'stock', 'featured',
        'bundle_quantity', 'bundle_price'
    ];
    
    protected $casts = [
    'featured' => 'boolean',
    'min_increment' => 'decimal:2',
    'bundle_quantity' => 'integer',
    'bundle_price' => 'decimal:2',
    ];

    // Check if product has bundle offer
    public function hasBundle()
    {
        return $this->bundle_quantity > 0 && $this->bundle_price > 0;
    }

    // Calculate bundle savings
    public function getBundleSavings()
    {
        if (!$this->hasBundle()) {
            return 0;
        }
        
        $regularPrice = $this->price * $this->bundle_quantity;
        return $regularPrice - $this->bundle_price;
    }

    // Calculate bundle savings percentage
    public function getBundleSavingsPercentage()
    {
        if (!$this->hasBundle()) {
            return 0;
        }
        
        $regularPrice = $this->price * $this->bundle_quantity;
        return round((($regularPrice - $this->bundle_price) / $regularPrice) * 100);
    }

    // Calculate total price with bundle logic
    public function calculateTotalPrice($quantity)
    {
        if (!$this->hasBundle()) {
            return $quantity * $this->price;
        }

        $bundleQuantity = $this->bundle_quantity;
        $bundlePrice = $this->bundle_price;
        $regularPrice = $this->price;

        // Calculate how many complete bundles
        $completeBundles = intval($quantity / $bundleQuantity);
        $remainingItems = $quantity % $bundleQuantity;

        // Calculate total price
        $bundleTotal = $completeBundles * $bundlePrice;
        $regularTotal = $remainingItems * $regularPrice;

        return $bundleTotal + $regularTotal;
    }

    // Get bundle breakdown
    public function getBundleBreakdown($quantity)
    {
        if (!$this->hasBundle()) {
            return [
                'bundles' => 0,
                'remaining' => $quantity,
                'bundle_total' => 0,
                'regular_total' => $quantity * $this->price,
                'total' => $quantity * $this->price
            ];
        }

        $bundleQuantity = $this->bundle_quantity;
        $bundlePrice = $this->bundle_price;
        $regularPrice = $this->price;

        $completeBundles = intval($quantity / $bundleQuantity);
        $remainingItems = $quantity % $bundleQuantity;

        $bundleTotal = $completeBundles * $bundlePrice;
        $regularTotal = $remainingItems * $regularPrice;

        return [
            'bundles' => $completeBundles,
            'remaining' => $remainingItems,
            'bundle_total' => $bundleTotal,
            'regular_total' => $regularTotal,
            'total' => $bundleTotal + $regularTotal
        ];
    }
}