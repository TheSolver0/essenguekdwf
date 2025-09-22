<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Event;
use App\Models\User;
use App\Models\Media;
use App\Models\ContactMessage;

class AdminController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        $events = Event::latest()->get();
        $totalUsers = User::count();
        $users = User::all(); 
        $medias = Media::latest()->get();

        // Messages de contact
        $contactMessages = ContactMessage::latest()->get();
        $newMessages = ContactMessage::where('lu', false)->count(); // nombre de non lus
        $unreadSenders = ContactMessage::where('lu', false)
                            ->orderBy('created_at', 'desc')
                            ->take(5) // limite pour ne pas surcharger
                            ->get(['prenom','nom']);

        return view('dashboardAdmin', [
            'totalUsers'       => $totalUsers,
            'users'            => $users, 
            'totalDonations'   => 5482,
            'newMessages'      => $newMessages,
            'recentActivities' => 21,
            'posts'            => $posts,
            'events'           => $events,
            'medias'           => $medias,
            'contactMessages'  => $contactMessages,
            'unreadSenders'    => $unreadSenders,
        ]);
    }
}

