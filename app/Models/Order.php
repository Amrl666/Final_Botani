<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'nama_pemesan', 'telepon', 'alamat', 
        'jumlah', 'jumlah_orang', 'produk_id', 
        'eduwisata_id', 'total_harga', 'status',
        'tanggal_kunjungan', 'keterangan',
        'shipping_address_id', 'shipping_cost', 'delivery_method', 'estimated_delivery'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'tanggal_kunjungan' => 'date',
        'shipping_cost' => 'decimal:2',
        'estimated_delivery' => 'datetime',
    ];

    public function produk(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function eduwisata(): BelongsTo {
        return $this->belongsTo(Eduwisata::class);
    }

    // New relationship for multiple products
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Shipping address relationship
    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    // Delivery relationship
    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }

    // Helper method to get total items count
    public function getTotalItemsAttribute()
    {
        return $this->orderItems->sum('quantity');
    }

    // Helper method to check if order has multiple products
    public function getHasMultipleProductsAttribute()
    {
        return $this->orderItems->count() > 1;
    }

    // Payment relationship
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Customer relationship
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'telepon', 'phone');
    }

    // Helper method to check payment status
    public function getPaymentStatusAttribute()
    {
        return $this->payment ? $this->payment->status : 'unpaid';
    }

    // Helper method to check if order is paid
    public function getIsPaidAttribute()
    {
        return $this->payment && $this->payment->status === 'paid';
    }

    // Helper method to get total with shipping
    public function getTotalWithShippingAttribute()
    {
        return $this->total_harga + $this->shipping_cost;
    }

    // Helper method to check if order has delivery
    public function getHasDeliveryAttribute()
    {
        return $this->delivery_method === 'delivery';
    }
}
