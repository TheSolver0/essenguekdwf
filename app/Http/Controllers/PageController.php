<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Event;
use NotchPay\NotchPay;


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
        // return view('posts.activity');
    }

    public function processGive(Request $request) {
        // Validation des données du formulaire
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string', // Ajustez selon les devises supportées
            'payment_method' => 'required|string', // Ajustez selon les méthodes supportées
            'email' => 'required|email',
        ]);

        // Initialisation de NotchPay
        $notchPay = new NotchPay([
            'api_key' => env('pk_test.weaKZT9YdpOWqXsJlI0oeWB2V5ZlkXxJrvyWBoPV7hczLPca6t0s544UUvsrECQOidLUotTEEqYooAJRefQ6TROUh1zzB52RPk1SBi2IJhUbWDqC5GSkJgava3DSM'),
            'api_secret' => env('sk_test.PxsyqKQVqvRqEKEmAADvXkjDkFSm8DbTz388ZmwGxz4Hq3wVdPYryEWfsx9Xjy8MdzMJrHj8augUg1AWJaB6eZh1viiVu3wipposMWHd50OV78mBU2aZPFc7WxMS3'),
            'environment' => env('NOTCHPAY_ENVIRONMENT', 'sandbox'), // sandbox ou live
        ]);

        // Création de la transaction
        $transaction = $notchPay->createTransaction([
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'payment_method' => $validated['payment_method'],
            'customer_email' => $validated['email'],
            'description' => 'Donation to Essengue KDWF',
            'redirect_url' => route('home'), // URL de redirection après paiement
        ]);

        if ($transaction && isset($transaction['payment_url'])) {
            // Redirection vers l'URL de paiement fournie par NotchPay
            return redirect($transaction['payment_url']);
        } else {
            return back()->withErrors(['payment_error' => 'Unable to initiate payment. Please try again later.']);
        }
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
    public function give() {
        return view('give');
    }
}
