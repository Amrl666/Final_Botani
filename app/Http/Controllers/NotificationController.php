<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Customer;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function index()
    {
        $notifications = Notification::with('customer')
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => Notification::count(),
            'unread' => Notification::unread()->count(),
            'read' => Notification::read()->count(),
        ];

        return view('dashboard.notifications.index', compact('notifications', 'stats'));
    }

    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();
        return back()->with('success', 'Notifikasi ditandai sebagai telah dibaca.');
    }

    public function markAllAsRead()
    {
        Notification::unread()->update(['read_at' => now()]);
        return back()->with('success', 'Semua notifikasi ditandai sebagai telah dibaca.');
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'type' => 'required|in:order_status,payment,stock_alert,promo,system',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'customer_ids' => 'nullable|array',
            'customer_ids.*' => 'exists:customers,id',
            'send_whatsapp' => 'boolean',
        ]);

        $customers = $request->filled('customer_ids') 
            ? Customer::whereIn('id', $request->customer_ids)->get()
            : Customer::all();

        $successCount = 0;
        $whatsappCount = 0;

        foreach ($customers as $customer) {
            // Create notification
            $notification = Notification::create([
                'customer_id' => $customer->id,
                'type' => $request->type,
                'title' => $request->title,
                'message' => $request->message,
                'data' => $request->only(['type']),
            ]);

            $successCount++;

            // Send WhatsApp if requested
            if ($request->boolean('send_whatsapp')) {
                if ($this->whatsappService->sendText($customer->phone, $request->message)) {
                    $whatsappCount++;
                }
            }
        }

        $message = "Berhasil mengirim {$successCount} notifikasi";
        if ($request->boolean('send_whatsapp')) {
            $message .= " dan {$whatsappCount} pesan WhatsApp";
        }

        return back()->with('success', $message);
    }

    public function sendPromoNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'send_whatsapp' => 'boolean',
        ]);

        $customers = Customer::where('is_active', true)->get();

        $successCount = 0;
        $whatsappCount = 0;

        foreach ($customers as $customer) {
            // Create notification
            Notification::create([
                'customer_id' => $customer->id,
                'type' => 'promo',
                'title' => $request->title,
                'message' => $request->message,
                'data' => ['type' => 'promo'],
            ]);

            $successCount++;

            // Send WhatsApp if requested
            if ($request->boolean('send_whatsapp')) {
                if ($this->whatsappService->sendText($customer->phone, $request->message)) {
                    $whatsappCount++;
                }
            }
        }

        $message = "Berhasil mengirim promo ke {$successCount} customer";
        if ($request->boolean('send_whatsapp')) {
            $message .= " dan {$whatsappCount} pesan WhatsApp";
        }

        return back()->with('success', $message);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function clearAll()
    {
        Notification::truncate();
        return back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }
}
