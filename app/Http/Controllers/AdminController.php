<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Event;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        $events = Event::latest()->get();
        $totalUsers = User::count();
        $users = User::all(); 

        return view('dashboardAdmin', [
            'totalUsers'       => $totalUsers,
             'users'            => $users, 
            'totalDonations'   => 5482,
            'newMessages'      => 23,
            'recentActivities' => 21,
            'posts'            => $posts,
            'events'           => $events,
        ]);
    }
}
