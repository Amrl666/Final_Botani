<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'shipping_address_id',
        'tracking_number',
        'courier_name',
        'courier_phone',
        'status',
        'shipping_cost',
        'notes',
        'estimated_delivery',
        'delivered_at'
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'estimated_delivery' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function trackingLogs()
    {
        return $this->hasMany(DeliveryTrackingLog::class);
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Menunggu Pengiriman',
            'picked_up' => 'Sudah Diambil',
            'in_transit' => 'Dalam Perjalanan',
            'out_for_delivery' => 'Sedang Dikirim',
            'delivered' => 'Terkirim',
            'failed' => 'Gagal Dikirim'
        ];

        return $statuses[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'picked_up' => 'info',
            'in_transit' => 'primary',
            'out_for_delivery' => 'info',
            'delivered' => 'success',
            'failed' => 'danger'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function updateStatus($status, $description = null, $location = null)
    {
        $this->update(['status' => $status]);

        if ($status === 'delivered') {
            $this->update(['delivered_at' => now()]);
        }

        // Create tracking log
        $this->trackingLogs()->create([
            'status' => $status,
            'description' => $description ?? $this->getStatusTextAttribute(),
            'location' => $location,
            'tracked_at' => now()
        ]);
    }

    public static function generateTrackingNumber()
    {
        do {
            $trackingNumber = 'TRK' . date('Ymd') . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('tracking_number', $trackingNumber)->exists());

        return $trackingNumber;
    }
} 