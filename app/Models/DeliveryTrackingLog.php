<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTrackingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',
        'status',
        'description',
        'location',
        'tracked_at'
    ];

    protected $casts = [
        'tracked_at' => 'datetime',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
} 