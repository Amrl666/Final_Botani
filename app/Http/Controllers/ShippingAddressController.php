<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::guard('customer')->user()->shippingAddresses()->orderBy('is_default', 'desc')->get();
        return view('frontend.customer.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('frontend.customer.addresses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'province' => 'required|string|max:100',
            'notes' => 'nullable|string|max:255',
            'is_default' => 'boolean'
        ]);

        $customer = Auth::guard('customer')->user();

        if ($request->is_default) {
            ShippingAddress::setDefault($customer->id, null);
        }

        $address = $customer->shippingAddresses()->create($request->all());

        return redirect()->route('customer.addresses.index')
            ->with('success', 'Alamat pengiriman berhasil ditambahkan');
    }

    public function edit(ShippingAddress $address)
    {
        // Check if address belongs to authenticated customer
        if ($address->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('frontend.customer.addresses.edit', compact('address'));
    }

    public function update(Request $request, ShippingAddress $address)
    {
        // Check if address belongs to authenticated customer
        if ($address->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'recipient_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'province' => 'required|string|max:100',
            'notes' => 'nullable|string|max:255',
            'is_default' => 'boolean'
        ]);

        if ($request->is_default) {
            ShippingAddress::setDefault($address->customer_id, $address->id);
        }

        $address->update($request->all());

        return redirect()->route('customer.addresses.index')
            ->with('success', 'Alamat pengiriman berhasil diperbarui');
    }

    public function destroy(ShippingAddress $address)
    {
        // Check if address belongs to authenticated customer
        if ($address->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $address->delete();

        return redirect()->route('customer.addresses.index')
            ->with('success', 'Alamat pengiriman berhasil dihapus');
    }

    public function setDefault(ShippingAddress $address)
    {
        // Check if address belongs to authenticated customer
        if ($address->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        ShippingAddress::setDefault($address->customer_id, $address->id);

        return redirect()->route('customer.addresses.index')
            ->with('success', 'Alamat default berhasil diubah');
    }
} 