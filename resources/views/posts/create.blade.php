@extends('layouts.app')

@section('content')
<div class="relative flex flex-col items-center min-h-[calc(100vh-8rem-10rem)] px-4 mt-32">

    {{-- Conteneur principal --}}
    <div 
      class="relative w-full max-w-4xl bg-stone-50 bg-opacity-95 rounded-xl shadow-xl p-6 z-10 
             border-4 border-double border-sky-500 border-r-lime-500 border-t-sky-500 border-b-lime-500 rounded-lg"
      style="backdrop-filter: blur(8px);"
    >
        {{-- Logo au-dessus du formulaire --}}
        <div class="flex justify-center mb-6">
            <img src="/images/logotype.png" alt="Logo KDWFoundation" class="w-32 h-auto" />
        </div>

        {{-- Titre --}}
        <h2 class="text-center text-3xl font-bold text-sky-700 mb-8 select-none">Créer un nouveau post</h2>

        {{-- Affichage des erreurs --}}
        @if ($errors->any())
            <div class="mb-4 font-medium text-sm text-red-600 animate-fade-up border border-red-400 bg-red-100 p-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulaire --}}
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
              class="border-4 border-double border-lime-500 border-r-sky-500 border-t-lime-500 border-b-sky-500 rounded-lg p-6 space-y-5">
            @csrf

            {{-- Titre du post --}}
            <div>
                <x-label for="title" value="Titre du post" class="text-sky-700 font-semibold" />
                <x-input id="title" type="text" name="title"
                         class="mt-1 block w-full border border-sky-300 rounded-md
                                focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                                transition duration-300"
                         required />
            </div>

            {{-- Contenu --}}
            <div>
                <x-label for="body" value="Contenu du post" class="text-sky-700 font-semibold" />
                <textarea id="body" name="body" rows="5"
                          class="mt-1 block w-full border border-sky-300 rounded-md
                                 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                                 transition duration-300"></textarea>
            </div>

            {{-- Fichiers --}}
            <div>
                <x-label for="media" value="Ajouter des images ou vidéos" class="text-sky-700 font-semibold" />
                <input id="media" type="file" name="media[]" accept="image/*,video/*" multiple
                       class="mt-1 block w-full border border-sky-300 rounded-md p-2
                              focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                              transition duration-300" />
            </div>

            {{-- Boutons --}}
            <div class="flex justify-between">
                {{-- Bouton Publier --}}
                <x-button
                    class="bg-sky-600 hover:bg-sky-800 focus:ring-4 focus:ring-sky-300
                        text-white font-bold py-2 px-6 rounded-lg transition transform
                        hover:scale-105 active:scale-95">
                    Publier
                </x-button>

                {{-- Bouton Annuler --}}
                <a href="{{ url()->previous() }}"
                class="bg-red-500 hover:bg-red-700 focus:ring-4 focus:ring-gray-300
                        text-white font-bold py-2 px-6 rounded-lg transition transform
                        hover:scale-105 active:scale-95">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Animation fade-up */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-up {
        animation: fadeUp 0.7s ease forwards;
    }
</style>
@endpush
