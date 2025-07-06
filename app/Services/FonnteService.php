<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $apiKey;
    protected $deviceId;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.fonnte.api_key');
        $this->deviceId = config('services.fonnte.device_id');
        $this->baseUrl = 'https://api.fonnte.com/send';
    }

    /**
     * Send WhatsApp message via Fonnte
     */
    public function sendMessage($phone, $message, $options = [])
    {
        try {
            // Format phone number (remove +62, add 62)
            $phone = $this->formatPhoneNumber($phone);

            $payload = [
                'target' => $phone,
                'message' => $message,
                'countryCode' => '62',
            ];

            // Add optional parameters
            if (isset($options['delay'])) {
                $payload['delay'] = $options['delay'];
            }

            if (isset($options['link'])) {
                $payload['link'] = $options['link'];
            }

            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->post($this->baseUrl, $payload);

            if ($response->successful()) {
                Log::info('Fonnte message sent successfully', [
                    'phone' => $phone,
                    'response' => $response->json()
                ]);
                return $response->json();
            } else {
                Log::error('Fonnte message failed', [
                    'phone' => $phone,
                    'response' => $response->json()
                ]);
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Fonnte service error', [
                'message' => $e->getMessage(),
                'phone' => $phone ?? 'unknown'
            ]);
            return false;
        }
    }

    /**
     * Send order notification to admin
     */
    public function sendOrderNotification($orderData)
    {
        $message = $this->formatOrderMessage($orderData);
        
        $adminPhone = config('services.fonnte.admin_phone', '6282379044166');
        
        return $this->sendMessage($adminPhone, $message);
    }

    /**
     * Send order confirmation to customer
     */
    public function sendOrderConfirmation($orderData)
    {
        $message = $this->formatCustomerMessage($orderData);
        
        return $this->sendMessage($orderData['telepon'], $message);
    }

    /**
     * Send contact notification to admin
     */
    public function sendContactNotification($contactData)
    {
        $message = $this->formatContactMessage($contactData);
        
        $adminPhone = config('services.fonnte.admin_phone', '6282379044166');
        
        return $this->sendMessage($adminPhone, $message);
    }

    /**
     * Send contact confirmation to customer
     */
    public function sendContactConfirmation($contactData)
    {
        $message = $this->formatContactCustomerMessage($contactData);
        
        return $this->sendMessage($contactData['whatsapp'], $message);
    }

    /**
     * Format order message for admin
     */
    protected function formatOrderMessage($orderData)
    {
        $nama = $orderData['nama_pemesan'];
        $telepon = $orderData['telepon'];
        $alamat = $orderData['alamat'] ?? '-';
        $jumlah = $orderData['jumlah_orang'] ?? $orderData['jumlah'] ?? 0;
        $tanggal = $orderData['tanggal_kunjungan'] ?? '-';
        $harga = $orderData['total_harga'];
        $namaItem = $orderData['nama_item'] ?? 'Produk';
        $keterangan = $orderData['keterangan'] ?? '';
        $jenis = $orderData['jenis'] ?? 'produk';

        $unit = isset($orderData['jumlah_orang']) ? 'orang' : ($orderData['unit'] ?? 'satuan');
        $jumlahText = $jumlah . ' ' . $unit;

        $message = "🛒 *PESANAN BARU*\n\n";
        $message .= "📋 *Detail Pesanan:*\n";
        
        if ($jenis === 'produk') {
            $message .= "🛍️ *Produk:*\n";
            $message .= "• Nama: $nama\n";
            $message .= "• No HP: $telepon\n";
            $message .= "• Alamat: $alamat\n";
            $message .= "• Produk: *$namaItem*\n";
            $message .= "• Jumlah: $jumlahText\n";
            
            // Add bundle breakdown if available
            if (isset($orderData['bundle_breakdown'])) {
                $breakdown = $orderData['bundle_breakdown'];
                if ($breakdown['bundles'] > 0) {
                    $message .= "• Bundle: {$breakdown['bundles']}x{$orderData['bundle_quantity']}";
                    if ($breakdown['remaining'] > 0) {
                        $message .= " + {$breakdown['remaining']} satuan";
                    }
                    $message .= "\n";
                    $message .= "• Harga Bundle: Rp " . number_format($breakdown['bundle_total'], 0, ',', '.') . "\n";
                    if ($breakdown['remaining'] > 0) {
                        $message .= "• Harga Satuan: Rp " . number_format($breakdown['regular_total'], 0, ',', '.') . "\n";
                    }
                }
            }
            
            // Add multiple bundle breakdowns for cart orders
            if (isset($orderData['all_bundle_breakdowns']) && !empty($orderData['all_bundle_breakdowns'])) {
                $message .= "\n📦 *Detail Bundle:*\n";
                foreach ($orderData['all_bundle_breakdowns'] as $bundleData) {
                    $breakdown = $bundleData['breakdown'];
                    if ($breakdown['bundles'] > 0) {
                        $message .= "• {$bundleData['product_name']}:\n";
                        $message .= "  Bundle: {$breakdown['bundles']}x{$bundleData['bundle_quantity']}";
                        if ($breakdown['remaining'] > 0) {
                            $message .= " + {$breakdown['remaining']} satuan";
                        }
                        $message .= "\n";
                        $message .= "  Harga: Rp " . number_format($breakdown['total'], 0, ',', '.') . "\n";
                    }
                }
            }
        } else {
            $message .= "🎓 *Eduwisata:*\n";
            $message .= "• Nama: $nama\n";
            $message .= "• No HP: $telepon\n";
            $message .= "• Alamat: $alamat\n";
            $message .= "• Paket: *$namaItem*\n";
            $message .= "• Jumlah: $jumlahText\n";
            $message .= "• Tanggal Kunjungan: $tanggal\n";
        }
        
        $message .= "• Total: Rp " . number_format($harga, 0, ',', '.') . "\n";

        if ($keterangan) {
            $message .= "• Catatan: $keterangan\n";
        }

        $message .= "\n⏰ *Waktu Order:* " . now()->format('d/m/Y H:i:s');
        $message .= "\n\n💬 Silakan hubungi customer untuk konfirmasi.";

        return $message;
    }

    /**
     * Format confirmation message for customer
     */
    protected function formatCustomerMessage($orderData)
    {
        $nama = $orderData['nama_pemesan'];
        $namaItem = $orderData['nama_item'] ?? 'Produk';
        $harga = $orderData['total_harga'];

        $message = "✅ *KONFIRMASI PESANAN*\n\n";
        $message .= "Halo $nama,\n\n";
        $message .= "Terima kasih telah memesan *$namaItem*.\n";
        $message .= "Total pembayaran: *Rp " . number_format($harga, 0, ',', '.') . "*\n\n";
        $message .= "📞 Admin akan segera menghubungi Anda untuk konfirmasi lebih lanjut.\n\n";
        $message .= "🙏 Mohon tunggu pesan dari kami.";

        return $message;
    }

    /**
     * Format contact message for admin
     */
    protected function formatContactMessage($contactData)
    {
        $nama = $contactData['name'];
        $whatsapp = $contactData['whatsapp'];
        $subject = $contactData['subject'];
        $message = $contactData['message'];

        $waMessage = "📞 *PESAN KONTAK BARU*\n\n";
        $waMessage .= "👤 *Detail Pengirim:*\n";
        $waMessage .= "• Nama: $nama\n";
        $waMessage .= "• WhatsApp: $whatsapp\n";
        $waMessage .= "• Subjek: *$subject*\n\n";
        $waMessage .= "💬 *Pesan:*\n";
        $waMessage .= "$message\n\n";
        $waMessage .= "⏰ *Waktu:* " . now()->format('d/m/Y H:i:s') . "\n\n";
        $waMessage .= "📱 Silakan balas langsung ke WhatsApp pengirim.";

        return $waMessage;
    }

    /**
     * Format contact confirmation message for customer
     */
    protected function formatContactCustomerMessage($contactData)
    {
        $nama = $contactData['name'];
        $subject = $contactData['subject'];

        $message = "✅ *KONFIRMASI PESAN KONTAK*\n\n";
        $message .= "Halo $nama,\n\n";
        $message .= "Terima kasih telah menghubungi kami dengan subjek:\n";
        $message .= "*$subject*\n\n";
        $message .= "📞 Tim kami akan segera menghubungi Anda untuk memberikan jawaban yang terbaik.\n\n";
        $message .= "🙏 Mohon tunggu pesan dari kami dalam waktu 1x24 jam.\n\n";
        $message .= "Best regards,\n";
        $message .= "Tim Tani Winongo Asri";

        return $message;
    }

    /**
     * Format phone number for Fonnte
     */
    protected function formatPhoneNumber($phone)
    {
        // Remove any non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Remove leading 0 and add 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        // If already starts with 62, keep as is
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }
        
        return $phone;
    }

    /**
     * Check device status
     */
    public function checkDeviceStatus()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->get('https://api.fonnte.com/device');

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Fonnte device status check failed', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }
} 