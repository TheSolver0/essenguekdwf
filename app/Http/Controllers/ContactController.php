<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;

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
        $data = $request->validate([
            'prenom'    => 'required|string|max:100',
            'nom'       => 'required|string|max:100',
            'adresse'   => 'nullable|string|max:255',
            'ville'     => 'nullable|string|max:100',
            'region'    => 'nullable|string|max:100',
            'zip'       => 'nullable|string|max:20',
            'email'     => 'required|email',
            'telephone' => 'nullable|string|max:20',
            'message'   => 'required|string|max:5000',
        ]);

        // Enregistrement en base
        ContactMessage::create([
            'prenom'    => $request->prenom,
            'nom'       => $request->nom,
            'adresse'   => $request->adresse,
            'ville'     => $request->ville,
            'region'    => $request->region,
            'zip'       => $request->zip,
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'message'   => $request->message,
        ]);
      Mail::to('contact@kingsdreamworldfoundation.org')->send(new ContactMessageMail($data));

        // Envoi par email (optionnel)
        // $data = $request->all();
        // Mail::send('emails.contact', ['data' => $data], function($message) use ($data) {
        //     $message->to('contact@kingsdreamworldfoundation.org')
        //             ->subject('Nouveau message depuis le formulaire de contact');
        // });

        return back()->with('success', 'Merci ! Votre message a été envoyé avec succès.');
    }

    public function markRead(ContactMessage $msg)
    {
        $msg->lu = true;
        $msg->save();
        return back();
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->back()->with('success', 'Message supprimé avec succès ✅');
    }


}
