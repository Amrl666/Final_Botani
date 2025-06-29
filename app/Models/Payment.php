<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'status',
        'payment_proof',
        'notes',
        'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Payment method options
    public static function getPaymentMethods()
    {
        return [
            'transfer' => 'Transfer Bank',
            'cod' => 'Cash on Delivery (COD)',
            'ewallet' => 'E-Wallet',
        ];
    }

    // Status options
    public static function getStatuses()
    {
        return [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'failed' => 'Gagal',
            'expired' => 'Kadaluarsa',
        ];
    }

    // Helper methods
    public function getStatusTextAttribute()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'expired' => 'secondary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getPaymentMethodTextAttribute()
    {
        $methods = self::getPaymentMethods();
        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    public function getIsPaidAttribute()
    {
        return $this->status === 'paid';
    }

    public function getIsPendingAttribute()
    {
        return $this->status === 'pending';
    }

    public function getIsFailedAttribute()
    {
        return in_array($this->status, ['failed', 'expired']);
    }
}
