@extends('layouts.app')

@section('content')
<div class="relative flex flex-col items-center min-h-[calc(100vh-8rem-10rem)] px-4 mt-32">

    <div 
      class="relative w-full max-w-3xl bg-stone-50 bg-opacity-95 rounded-xl shadow-xl p-8 z-10 
             border-4 border-double border-blue-500 border-r-lime-500 border-t-blue-500 border-b-lime-500"
      style="backdrop-filter: blur(8px);"
    >
        <div class="flex justify-center mb-6">
            <img src="/images/logotype.png" alt="Logo KDWFoundation" class="w-28 h-auto" />
        </div>

        <h2 class="text-center text-3xl font-bold text-blue-700 mb-8 select-none">Ajouter un média à la médiathèque</h2>

        @if ($errors->any())
            <div class="mb-4 font-medium text-sm text-red-600 animate-fade-up border border-red-400 bg-red-100 p-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.medias.store') }}" method="POST" enctype="multipart/form-data"
              class="border-4 border-double border-lime-500 border-r-blue-500 border-t-lime-500 border-b-blue-500 rounded-lg p-6 space-y-5">
            @csrf

            {{-- Titre --}}
            <div>
                <label for="nom" class="text-blue-700 font-semibold">Titre du média</label>
                <input id="nom" type="text" name="nom"
                       class="mt-1 block w-full border border-blue-300 rounded-md
                              focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                              transition duration-300"
                       required />
            </div>

            {{-- Implantation --}}
            <div>
                <label for="implantation" class="text-blue-700 font-semibold">Implantation</label>
                <input id="implantation" type="text" name="implantation"
                       class="mt-1 block w-full border border-blue-300 rounded-md
                              focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                              transition duration-300"
                       required />
            </div>

            {{-- Catégorie --}}
            <div>
                <label for="category" class="text-blue-700 font-semibold">Catégorie</label>
                <select id="category" name="category"
                        class="mt-1 block w-full border border-blue-300 rounded-md
                               focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                               transition duration-300"
                        required>
                    <option value="photo">Photo</option>
                    <option value="video">Vidéo</option>
                    <option value="rapport">Rapport d'activité (PDF)</option>
                </select>
            </div>

            {{-- Fichiers --}}
            <div>
                <label for="media_url" class="text-blue-700 font-semibold">Fichier(s) à uploader</label>
                <input id="media_url" type="file" name="media_url[]" 
                       accept="image/*,video/*,application/pdf"
                       multiple
                       class="mt-1 block w-full border border-blue-300 rounded-md p-2
                              focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                              transition duration-300"
                       required />
            </div>

            {{-- Boutons --}}
            <div class="flex justify-between">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                        text-white font-bold py-2 px-6 rounded-lg transition transform
                        hover:scale-105 active:scale-95">
                    Publier
                </button>
                <a href="{{ route('admin.dashboard') }}"
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
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px);}
        to { opacity: 1; transform: translateY(0);}
    }
    .animate-fade-up { animation: fadeUp 0.7s ease forwards; }
</style>
@endpush