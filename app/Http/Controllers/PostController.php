<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Post;
class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['comments', 'likes'])->orderByDesc('id')->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240', // 10MB max
        ]);

        $path = null;
        $type = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';
            $path = $file->store('posts', 'public'); // stocké dans storage/app/public/posts
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'body' => $validated['body'] ?? null,
            'media_type' => $type,
            'media_url' => $path ? Storage::url($path) : null,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post créé avec succès !');

    }

    public function show(Post $post)
    {
        return $post->load(['comments', 'likes']);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }


}
