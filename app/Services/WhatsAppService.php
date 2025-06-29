<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiUrl;
    protected $token;
    protected $phoneNumberId;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url', 'https://graph.facebook.com/v18.0');
        $this->token = config('services.whatsapp.token');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id');
    }

    /**
     * Send text message
     */
    public function sendText($to, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/' . $this->phoneNumberId . '/messages', [
                'messaging_product' => 'whatsapp',
                'to' => $this->formatPhoneNumber($to),
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'to' => $to,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::error('WhatsApp message failed', [
                    'to' => $to,
                    'response' => $response->json()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp service error', [
                'message' => $e->getMessage(),
                'to' => $to
            ]);
            return false;
        }
    }

    /**
     * Send order confirmation
     */
    public function sendOrderConfirmation($order)
    {
        $message = "🎉 *Pesanan Dikonfirmasi!*\n\n";
        $message .= "Halo {$order->nama_pemesan},\n";
        $message .= "Pesanan Anda telah dikonfirmasi dan sedang diproses.\n\n";
        
        if ($order->orderItems->isNotEmpty()) {
            $message .= "*Detail Pesanan:*\n";
            foreach ($order->orderItems as $item) {
                $message .= "• {$item->product->name}: {$item->quantity} {$item->product->unit}\n";
            }
        } else {
            $itemName = $order->produk ? $order->produk->name : $order->eduwisata->name;
            $unit = $order->produk ? $order->produk->unit : 'orang';
            $jumlah = $order->produk_id ? $order->jumlah : $order->jumlah_orang;
            $message .= "*Detail Pesanan:*\n";
            $message .= "• {$itemName}: {$jumlah} {$unit}\n";
        }
        
        $message .= "\n*Total: Rp " . number_format($order->total_harga, 0, ',', '.') . "*\n";
        $message .= "\nTerima kasih telah berbelanja di Kelompok Tani Winongo Asri! 🌱";

        return $this->sendText($order->telepon, $message);
    }

    /**
     * Send payment confirmation
     */
    public function sendPaymentConfirmation($payment)
    {
        $order = $payment->order;
        $message = "💰 *Pembayaran Diterima!*\n\n";
        $message .= "Halo {$order->nama_pemesan},\n";
        $message .= "Pembayaran Anda telah kami terima dan diverifikasi.\n\n";
        $message .= "*Detail Pembayaran:*\n";
        $message .= "• Metode: " . ucfirst($payment->payment_method) . "\n";
        $message .= "• Jumlah: Rp " . number_format($payment->amount, 0, ',', '.') . "\n";
        $message .= "• Status: Sudah Dibayar\n\n";
        $message .= "Pesanan Anda akan segera diproses. Terima kasih! 🙏";

        return $this->sendText($order->telepon, $message);
    }

    /**
     * Send stock alert
     */
    public function sendStockAlert($product)
    {
        $message = "⚠️ *Peringatan Stok Rendah!*\n\n";
        $message .= "Produk: {$product->name}\n";
        $message .= "Stok saat ini: {$product->stock} {$product->unit}\n";
        $message .= "Status: Stok hampir habis\n\n";
        $message .= "Silakan cek dan update stok produk ini.";

        // Send to admin
        $adminPhone = config('services.whatsapp.admin_phone');
        return $this->sendText($adminPhone, $message);
    }

    /**
     * Send promo notification
     */
    public function sendPromoNotification($customers, $promoMessage)
    {
        $successCount = 0;
        foreach ($customers as $customer) {
            if ($this->sendText($customer->phone, $promoMessage)) {
                $successCount++;
            }
        }
        return $successCount;
    }

    /**
     * Format phone number for WhatsApp API
     */
    protected function formatPhoneNumber($phone)
    {
        // Remove any non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Add country code if not present
        if (!str_starts_with($phone, '62')) {
            $phone = '62' . ltrim($phone, '0');
        }
        
        return $phone;
    }

    /**
     * Generate WhatsApp URL for manual sending
     */
    public function generateWhatsAppUrl($phone, $message)
    {
        $formattedPhone = $this->formatPhoneNumber($phone);
        return "https://wa.me/{$formattedPhone}?text=" . urlencode($message);
    }
}
