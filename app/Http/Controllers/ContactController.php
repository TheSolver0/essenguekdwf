<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Afficher le formulaire
    public function index()
    {
        return view('contact');
    }

    // Traiter le formulaire
    public function send(Request $request)
    {
        // Validation des champs
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'address'    => 'nullable|string|max:255',
            'city'       => 'nullable|string|max:100',
            'state'      => 'nullable|string|max:100',
            'zip'        => 'nullable|string|max:20',
            'email'      => 'required|email',
            'phone'      => 'nullable|string|max:20',
            'message'    => 'required|string|max:5000',
        ]);

        // Envoi par email
        $data = $request->all();

        Mail::send('emails.contact', ['data' => $data], function($message) use ($data) {
            $message->to('nathanbiloa@gmail.com') // remplace par le vrai email
                    ->subject('Nouveau message depuis le formulaire de contact');
        });

        return back()->with('success', 'Merci ! Votre message a été envoyé avec succès.');
    }
}
