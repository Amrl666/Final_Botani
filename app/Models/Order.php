<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'nama_pemesan', 'telepon', 'alamat', 
        'jumlah', 'jumlah_orang', 'produk_id', 
        'eduwisata_id', 'total_harga', 'status',
        'tanggal_kunjungan', 'keterangan'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'tanggal_kunjungan' => 'date',
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
}
