<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('media')->orderBy('start_date', 'asc')->get();

        return view('events.index', compact('events'));
    }


    /**
     * Formulaire création
     */
    public function create()
    {
        return view('events.create'); // formulaire de création reste
    }

    /**
     * Enregistrement d’un événement
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'media.*'     => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi',
        ]);

        $event = Event::create($request->only(['title','description','location','start_date','end_date']));

        if ($request->hasFile('media')) {
            //dd($request->file('media')); // Vérifie si les fichiers sont reçus
            foreach ($request->file('media') as $file) {
                $path = $file->store('events','public');
                $type = str_contains($file->getMimeType(),'video') ? 'video' : 'image';

                $event->media()->create([
                    'media_url'  => $path,
                    'media_type' => $type,
                ]);
            }
        }

        // TEST : affiche les médias liés à l'événement
        //dd($event->media);

        // Redirection vers la home (accueil) avec message de succès
        return redirect()->route('home')->with('success', 'Événement créé avec succès.');
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event')); // formulaire reste
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'media.*'     => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi',
        ]);

        $event->update($request->only(['title','description','location','start_date','end_date']));

        if ($request->hasFile('media')) {
            //dd($request->file('media')); // Vérifie si les fichiers sont reçus
            foreach ($request->file('media') as $file) {
                $path = $file->store('events','public');
                $type = str_contains($file->getMimeType(),'video') ? 'video' : 'image';

                $event->media()->create([
                    'media_url'  => $path,
                    'media_type' => $type,
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'Événement mis à jour.');
    }

    /**
     * Suppression
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('home')->with('success', 'Événement supprimé.');
    }
}
