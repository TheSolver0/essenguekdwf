<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Event;



class PageController extends Controller
{
    public function home() {
         // Récupère les 3 derniers posts
        $latestPosts = Post::with(['media' => function ($query) {
            $query->orderBy('id')->limit(1); // on prend seulement le premier media
        }])->latest()->take(3)->get();

        //return view('home', compact('latestPosts'));

        //dd($latestPosts); // <-- Vérifie ici si des données remontent

        // Prochains événements
        $events = Event::with(['media' => function ($query) {
            $query->orderBy('id')->limit(3); // on prend jusqu'à 3 médias pour le carrousel
        }])
        ->where('start_date', '>=', now()) // uniquement les événements futurs
        ->orderBy('start_date', 'asc')
        ->take(5)
        ->get();

        //dd($events->toArray());

        //dd(Event::all()); // pour voir tout ce qui est en DB
        //dd(Event::where('start_date', '>=', now())->get()); // pour tester la requête


        return view('home', compact('latestPosts', 'events'));
  
    }

    public function about() {
        return view('about');
    }

    public function activity() {
        return view('activity');
    }

    public function showPost(Post $post)
    {
        // Eager load des médias pour ce post
        $post->load('media');

        return view('activity-show', compact('post'));
    }


    public function media() {
        return view('media');
    }

    public function implantation() {
        return view('implantation');
    }

    public function contact() {
        return view('contact');
    }
}