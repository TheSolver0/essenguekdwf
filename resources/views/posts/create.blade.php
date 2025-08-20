@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-8 bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Créer un nouveau post</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <input type="text" name="title" placeholder="Titre du post"
              class="w-full border rounded p-2" required>

        <textarea name="body" rows="4" placeholder="Contenu du post"
                  class="w-full border rounded p-2"></textarea>

        <!-- Le "multiple" permet de sélectionner plusieurs fichiers -->
        <input type="file" name="media[]" accept="image/*,video/*" multiple
              class="w-full p-2 border rounded">

        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
            Publier
        </button>
    </form>

</div>
@endsection
