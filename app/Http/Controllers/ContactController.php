<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\FonnteService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('Frontend.contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'whatsapp' => 'required|regex:/^[0-9]{10,15}$/',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Create contact record
        Contact::create($validated);

        // Send WhatsApp notifications via Fonnte
        $fonnteService = new FonnteService();
        
        // Send notification to admin
        $fonnteService->sendContactNotification($validated);
        
        // Send confirmation to customer
        $fonnteService->sendContactConfirmation($validated);

        return redirect('contact')
            ->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda via WhatsApp!');
    }

    // Admin Method untuk melihat pesan
    public function messages()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('dashboard.contact.index', compact('contacts'));
    }

    public function showMessage(Contact $contact)
    {
        if (is_null($contact->read_at)) {
            $contact->update(['read_at' => now()]);
        }
        return view('dashboard.contact.show', compact('contact'));
    }

    public function destroyMessage(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('dashboard.contact.messages')
            ->with('success', 'Pesan berhasil dihapus');
    }
}