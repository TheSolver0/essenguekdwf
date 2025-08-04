
@extends('layouts.app')

@section('content')

<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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
</form>

@endsection

