<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::with(['order', 'shippingAddress'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('dashboard.delivery.index', compact('deliveries'));
    }

    public function create(Order $order)
    {
        // Validasi bahwa pesanan sudah disetujui dan belum ada pengiriman
        if ($order->status !== 'disetujui') {
            return redirect()->route('dashboard.orders.index')
                ->with('error', 'Pesanan harus disetujui terlebih dahulu sebelum membuat pengiriman.');
        }

        if ($order->delivery) {
            return redirect()->route('dashboard.delivery.show', $order->delivery)
                ->with('info', 'Pengiriman untuk pesanan ini sudah ada.');
        }

        $shippingAddresses = ShippingAddress::all();
        return view('dashboard.delivery.create', compact('order', 'shippingAddresses'));
    }

    public function store(Request $request, Order $order)
    {
        // Validasi status pesanan
        if ($order->status !== 'disetujui') {
            return redirect()->route('dashboard.orders.index')
                ->with('error', 'Pesanan harus disetujui terlebih dahulu sebelum membuat pengiriman.');
        }

        if ($order->delivery) {
            return redirect()->route('dashboard.delivery.show', $order->delivery)
                ->with('info', 'Pengiriman untuk pesanan ini sudah ada.');
        }

        $request->validate([
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
            'courier_name' => 'required|string|max:100',
            'courier_phone' => 'nullable|string|max:20',
            'shipping_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'estimated_delivery' => 'nullable|date|after:today'
        ]);

        DB::transaction(function () use ($request, $order) {
            // Create delivery
            $delivery = Delivery::create([
                'order_id' => $order->id,
                'shipping_address_id' => $request->shipping_address_id,
                'tracking_number' => Delivery::generateTrackingNumber(),
                'courier_name' => $request->courier_name,
                'courier_phone' => $request->courier_phone,
                'shipping_cost' => $request->shipping_cost,
                'notes' => $request->notes,
                'estimated_delivery' => $request->estimated_delivery,
                'status' => 'pending'
            ]);

            // Update order
            $order->update([
                'delivery_method' => 'delivery',
                'shipping_cost' => $request->shipping_cost,
                'estimated_delivery' => $request->estimated_delivery
            ]);

            // Create initial tracking log
            $delivery->trackingLogs()->create([
                'status' => 'pending',
                'description' => 'Pesanan siap untuk pengiriman',
                'tracked_at' => now()
            ]);

            // Send WhatsApp notification to customer
            $this->sendDeliveryNotification($delivery);
        });

        return redirect()->route('dashboard.delivery.show', $order->delivery)
            ->with('success', 'Pengiriman berhasil dibuat dan notifikasi telah dikirim ke customer.');
    }

    public function show(Delivery $delivery)
    {
        $delivery->load(['order.orderItems.product', 'shippingAddress', 'trackingLogs']);
        return view('dashboard.delivery.show', compact('delivery'));
    }

    public function updateStatus(Request $request, Delivery $delivery)
    {
        // Debug: Log the request data
        \Log::info('Update Status Request', [
            'delivery_id' => $delivery->id,
            'request_data' => $request->all(),
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        $request->validate([
            'status' => 'required|in:pending,picked_up,in_transit,out_for_delivery,delivered,failed',
            'description' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
        ]);

        $oldStatus = $delivery->status;
        
        // Update delivery status
        $delivery->update([
            'status' => $request->status,
        ]);

        // Set delivered_at if status is delivered
        if ($request->status === 'delivered' && !$delivery->delivered_at) {
            $delivery->update(['delivered_at' => now()]);
        }

        // Create tracking log
        $trackingLog = $delivery->trackingLogs()->create([
            'status' => $request->status,
            'description' => $request->description ?: $this->getStatusDescription($request->status),
            'location' => $request->location,
            'tracked_at' => now()
        ]);

        // Debug: Log the created tracking log
        \Log::info('Tracking Log Created', [
            'tracking_log_id' => $trackingLog->id,
            'status' => $trackingLog->status,
            'description' => $trackingLog->description
        ]);

        // Send WhatsApp notification if status changed
        if ($oldStatus !== $request->status) {
            $this->sendStatusUpdateNotification($delivery, $request->status, $request->description, $request->location);
        }

        return back()->with('success', 'Status pengiriman berhasil diperbarui!');
    }

    protected function getStatusDescription($status)
    {
        $descriptions = [
            'pending' => 'Pesanan siap untuk pengiriman',
            'picked_up' => 'Pesanan telah diambil oleh kurir',
            'in_transit' => 'Pesanan dalam perjalanan',
            'out_for_delivery' => 'Pesanan sedang dikirim ke alamat tujuan',
            'delivered' => 'Pesanan telah diterima',
            'failed' => 'Pengiriman gagal'
        ];

        return $descriptions[$status] ?? 'Status diperbarui';
    }

    protected function sendStatusUpdateNotification($delivery, $status, $description, $location)
    {
        $order = $delivery->order;
        
        $statusText = ucfirst(str_replace('_', ' ', $status));
        
        $message = "📦 *Update Status Pengiriman*\n\n";
        $message .= "Halo {$order->nama_pemesan},\n";
        $message .= "Status pengiriman pesanan #{$order->id} telah diperbarui.\n\n";
        
        $message .= "*Status Baru:* {$statusText}\n";
        if ($description) {
            $message .= "*Deskripsi:* {$description}\n";
        }
        if ($location) {
            $message .= "*Lokasi:* {$location}\n";
        }
        
        $message .= "\n*Tracking Number:* {$delivery->tracking_number}\n";
        $message .= "Lacak pengiriman: " . url("/track/{$delivery->tracking_number}") . "\n\n";
        
        $message .= "Terima kasih telah berbelanja di Kelompok Tani Winongo Asri! 🌱";

        // Use WhatsApp service if available
        if (class_exists('\App\Services\WhatsAppService')) {
            $whatsappService = app('\App\Services\WhatsAppService');
            $whatsappService->sendText($order->telepon, $message);
        }
    }

    public function track($trackingNumber)
    {
        $delivery = Delivery::where('tracking_number', $trackingNumber)
            ->with(['order', 'shippingAddress', 'trackingLogs'])
            ->firstOrFail();

        return view('frontend.delivery.track', compact('delivery'));
    }

    // Customer deliveries
    public function customerDeliveries()
    {
        $customer = auth()->guard('customer')->user();
        $deliveries = Delivery::with(['order', 'trackingLogs'])
            ->whereHas('order', function($query) use ($customer) {
                $query->where('telepon', $customer->phone);
            })
            ->latest()
            ->paginate(10);

        return view('Frontend.customer.deliveries', compact('deliveries'));
    }

    protected function sendDeliveryNotification($delivery)
    {
        $order = $delivery->order;
        $shippingAddress = $delivery->shippingAddress;
        
        $message = "🚚 *Pengiriman Telah Dibuat!*\n\n";
        $message .= "Halo {$order->nama_pemesan},\n";
        $message .= "Pengiriman pesanan Anda telah dibuat dan sedang diproses.\n\n";
        
        $message .= "*Detail Pengiriman:*\n";
        $message .= "• Tracking Number: {$delivery->tracking_number}\n";
        $message .= "• Kurir: {$delivery->courier_name}\n";
        if ($delivery->courier_phone) {
            $message .= "• Telepon Kurir: {$delivery->courier_phone}\n";
        }
        $message .= "• Alamat: {$shippingAddress->full_address}\n";
        $message .= "• Biaya Kirim: Rp " . number_format($delivery->shipping_cost, 0, ',', '.') . "\n";
        
        if ($delivery->estimated_delivery) {
            $message .= "• Estimasi: " . $delivery->estimated_delivery->format('d/m/Y') . "\n";
        }
        
        $message .= "\n*Total Pembayaran:*\n";
        $message .= "• Subtotal: Rp " . number_format($order->total_harga, 0, ',', '.') . "\n";
        $message .= "• Ongkir: Rp " . number_format($delivery->shipping_cost, 0, ',', '.') . "\n";
        $message .= "• Total: Rp " . number_format($order->total_harga + $delivery->shipping_cost, 0, ',', '.') . "\n\n";
        
        $message .= "Anda dapat melacak pengiriman di:\n";
        $message .= url("/track/{$delivery->tracking_number}") . "\n\n";
        
        $message .= "Terima kasih telah berbelanja di Kelompok Tani Winongo Asri! 🌱";

        // Use WhatsApp service if available
        if (class_exists('\App\Services\WhatsAppService')) {
            $whatsappService = app('\App\Services\WhatsAppService');
            $whatsappService->sendText($order->telepon, $message);
        }
    }
} 