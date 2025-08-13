@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 space-y-6">
  @foreach ($posts as $post)
    <div class="bg-white rounded shadow p-6">
      <h2 class="text-xl font-semibold text-gray-800">{{ $post->title }}</h2>
      <p class="text-gray-700 mt-2">{{ $post->body }}</p>

      @if ($post->media_type === 'image')
        <img src="{{ $post->media_url }}" class="w-full mt-4 rounded" alt="Image du post">
      @elseif ($post->media_type === 'video')
        <video controls class="w-full mt-4 rounded">
          <source src="{{ $post->media_url }}" type="video/mp4">
        </video>
      @endif

      <form action="{{ route('posts.like', $post->id) }}" method="POST" class="mt-4">
        @csrf
        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          ❤️ Like ({{ $post->likes->count() }})
        </button>
      </form>

      <div class="mt-4">
        <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="space-y-2">
          @csrf
          <textarea name="content" rows="2" class="w-full border rounded p-2" placeholder="Ajouter un commentaire..."></textarea>
          <button type="submit" class="bg-lime-500 text-white px-4 py-2 rounded hover:bg-lime-600">Commenter</button>
        </form>

        <ul class="mt-4 space-y-2">
          @foreach ($post->comments as $comment)
            <li class="text-sm text-gray-600 border-l-4 border-lime-500 pl-3">
              {{ $comment->content }}
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  @endforeach
</div>
{{-- <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
  @csrf

  <input type="text" name="title" placeholder="Titre du post"
         class="w-full border rounded p-2" required>

  <textarea name="body" rows="4" placeholder="Contenu du post"
            class="w-full border rounded p-2" required></textarea>

  <input type="file" name="media" accept="image/*,video/*"
         class="w-full p-2 border rounded">

  <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
    Publier
  </button>
</form> --}}
@endsection
