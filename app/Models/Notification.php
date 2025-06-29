<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'type',
        'title',
        'message',
        'data',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Notification types
    public static function getTypes()
    {
        return [
            'order_status' => 'Status Pesanan',
            'payment' => 'Pembayaran',
            'stock_alert' => 'Peringatan Stok',
            'promo' => 'Promo',
            'system' => 'Sistem',
        ];
    }

    // Mark as read
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    // Check if notification is read
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    // Scope for unread notifications
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    // Scope for read notifications
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }
}
