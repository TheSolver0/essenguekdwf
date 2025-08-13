<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        // Empêche de liker deux fois
        if (!$post->likes()->where('user_id', auth()->id())->exists()) {
            $post->likes()->create(['user_id' => auth()->id()]);
        }

        return back()->with('success', 'Post liké !');
    }

    public function destroy(Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();
        return back()->with('success', 'Like supprimé.');
    }
}
