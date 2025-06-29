<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'recipient_name',
        'phone',
        'address',
        'city',
        'postal_code',
        'province',
        'notes',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->province} {$this->postal_code}";
    }

    public static function setDefault($customerId, $addressId)
    {
        // Remove default from other addresses
        self::where('customer_id', $customerId)
            ->where('is_default', true)
            ->update(['is_default' => false]);

        // Set new default
        if ($addressId) {
            self::where('id', $addressId)
                ->update(['is_default' => true]);
        }
    }

    // Helper methods
    public function getFormattedAddressAttribute()
    {
        $parts = [];
        
        if ($this->address) {
            $parts[] = $this->address;
        }
        
        if ($this->city) {
            $parts[] = $this->city;
        }
        
        if ($this->province) {
            $parts[] = $this->province;
        }
        
        if ($this->postal_code) {
            $parts[] = $this->postal_code;
        }
        
        return implode(', ', $parts);
    }

    public function getIsDefaultTextAttribute()
    {
        return $this->is_default ? 'Alamat Utama' : 'Alamat Tambahan';
    }

    public function getIsDefaultBadgeAttribute()
    {
        return $this->is_default ? 
            '<span class="badge badge-success">Alamat Utama</span>' : 
            '<span class="badge badge-secondary">Alamat Tambahan</span>';
    }
} 