<?php

namespace App\Http\Controllers;

use App\Models\Contact;
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
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        Contact::create($validated);

        return redirect('contact')
            ->with('success', 'Pesan Anda telah terkirim. Terima kasih!');
    }

    // Admin Method untuk melihat pesan
    public function messages()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('dashboard.contact.index', compact('contacts'));
    }

    public function showMessage(Contact $contact)
    {
        return view('dashboard.contact.show', compact('contact'));
    }

    public function destroyMessage(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('dashboard.contact.messages')
            ->with('success', 'Pesan berhasil dihapus');
    }
}