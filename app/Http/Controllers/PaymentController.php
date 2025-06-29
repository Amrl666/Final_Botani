<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        return view('Frontend.payment.show', compact('order'));
    }

    public function process(Request $request, Order $order)
    {
        $request->validate([
            'payment_method' => 'required|in:transfer,cod,ewallet',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string|max:255',
        ]);

        $paymentData = [
            'order_id' => $order->id,
            'payment_method' => $request->payment_method,
            'amount' => $order->total_harga,
            'status' => 'pending',
            'notes' => $request->notes,
        ];

        // Handle payment proof upload
        if ($request->hasFile('payment_proof')) {
            $paymentData['payment_proof'] = $request->file('payment_proof')
                ->store('payment_proofs', 'public');
        }

        // Create or update payment
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            $paymentData
        );

        // Update order status
        $order->update(['status' => 'menunggu_konfirmasi']);

        return redirect()->route('payment.success', $order)
            ->with('success', 'Pembayaran berhasil diproses! Admin akan memverifikasi pembayaran Anda.');
    }

    public function success(Order $order)
    {
        return view('Frontend.payment.success', compact('order'));
    }

    // Admin methods
    public function index(Request $request)
    {
        $query = Payment::with('order');
        
        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        $payments = $query->latest()->paginate(15);
        
        // Get statistics
        $stats = [
            'total' => Payment::count(),
            'paid' => Payment::where('status', 'paid')->count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'failed' => Payment::whereIn('status', ['failed', 'expired'])->count(),
        ];
        
        return view('dashboard.payment.index', compact('payments', 'stats'));
    }

    public function verify(Payment $payment)
    {
        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $payment->order->update(['status' => 'disetujui']);

        return back()->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    public function reject(Payment $payment)
    {
        $payment->update(['status' => 'failed']);
        $payment->order->update(['status' => 'menunggu']);

        return back()->with('success', 'Pembayaran ditolak!');
    }

    public function showAdmin(Payment $payment)
    {
        return view('dashboard.payment.show', compact('payment'));
    }
}
