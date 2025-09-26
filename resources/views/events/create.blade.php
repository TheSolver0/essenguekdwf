@extends('layouts.app')

@section('content')
<div class="relative flex flex-col items-center min-h-[calc(100vh-8rem-10rem)] px-4 pt-20">
    <div
      class="relative w-full max-w-md bg-stone-50 bg-opacity-95 rounded-xl shadow-xl p-8 z-10
             border-4 border-double border-sky-500 border-r-lime-500 border-t-sky-500 border-b-lime-500
             rounded-lg p-6"
      style="backdrop-filter: blur(8px);"
    >
        {{-- Logo --}}
        <div class="flex justify-center mb-6">
            <img src="/images/logotype.png" alt="Logo KDWFoundation" class="w-20 h-auto" />
        </div>

        {{-- Titre --}}
        <h2 class="text-center text-3xl font-bold text-sky-700 mb-8 select-none">Créer un événement</h2>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data"
              class="snake-border bg-stone-50 bg-opacity-95 rounded-lg p-6 relative"
              style="backdrop-filter: blur(8px);">
            @csrf

            {{-- Nom de l’événement --}}
            <div class="mb-5">
                <x-label for="title" value="Nom de l’événement" class="text-sky-700 font-semibold" />
                <x-input id="title" name="title" type="text"
                         class="mt-1 block w-full border border-sky-300 rounded-md
                                focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                                transition duration-300"
                         value="{{ old('title') }}" required />
            </div>

            {{-- Description --}}
            <div class="mb-5">
                <x-label for="description" value="Description" class="text-sky-700 font-semibold" />
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full border border-sky-300 rounded-md
                                 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                                 transition duration-300">{{ old('description') }}</textarea>
            </div>

            {{-- Dates de l’événement --}}
            <div class="mb-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Date de début --}}
                <div>
                    <x-label for="start_date" value="Date de début" class="text-sky-700 font-semibold" />
                    <x-input id="start_date" name="start_date" type="date"
                            class="mt-1 block w-full border border-sky-300 rounded-md
                                    focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                                    transition duration-300"
                            value="{{ old('start_date') }}"
                            required />
                </div>

                {{-- Date de fin --}}
                <div>
                    <x-label for="end_date" value="Date de fin" class="text-sky-700 font-semibold" />
                    <x-input id="end_date" name="end_date" type="date"
                            class="mt-1 block w-full border border-sky-300 rounded-md
                                    focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                                    transition duration-300"
                            value="{{ old('end_date') }}"
                            required />
                </div>
            </div>


            {{-- Lieu --}}
            <div class="mb-5">
                <x-label for="location" value="Lieu" class="text-sky-700 font-semibold" />
                <select id="location" name="location"
                    class="mt-1 block w-full border border-sky-300 rounded-md
                        focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                        transition duration-300"
                    required>
                    <option value="" class="font-semibold">-- Choisissez un lieu --</option>
                    <option value="Douala" {{ old('location') == 'Douala' ? 'selected' : '' }}>Douala</option>
                    <option value="Mfou" {{ old('location') == 'Mfou' ? 'selected' : '' }}>Mfou</option>
                    <option value="Bertoua" {{ old('location') == 'Bertoua' ? 'selected' : '' }}>Bertoua</option>
                    <option value="Bafia" {{ old('location') == 'Bafia' ? 'selected' : '' }}>Bafia</option>
                    <option value="Pouma" {{ old('location') == 'Pouma' ? 'selected' : '' }}>Pouma</option>
                    <option value="Ntui" {{ old('location') == 'Ntui' ? 'selected' : '' }}>Ntui</option>
                    <option value="Nkoteng" {{ old('location') == 'Nkoteng' ? 'selected' : '' }}>Nkoteng</option>
                    <option value="Awae" {{ old('location') == 'Awae' ? 'selected' : '' }}>Awae</option>
                    <option value="Esse" {{ old('location') == 'Esse' ? 'selected' : '' }}>Esse</option>
                    <option value="Mbankomo" {{ old('location') == 'Mbankomo' ? 'selected' : '' }}>Mbankomo</option>
                    <option value="Nyaho’o" {{ old('location') == 'Nyaho’o' ? 'selected' : '' }}>Nyaho’o</option>
                    <option value="Edea" {{ old('location') == 'Edea' ? 'selected' : '' }}>Edea</option>
                    <option value="Mbalmayo" {{ old('location') == 'Mbalmayo' ? 'selected' : '' }}>Mbalmayo</option>
                    <option value="Nkometou" {{ old('location') == 'Nkometou' ? 'selected' : '' }}>Nkometou</option>
                    <option value="Ebolowa" {{ old('location') == 'Ebolowa' ? 'selected' : '' }}>Ebolowa</option>
                    <option value="Nkolafamba" {{ old('location') == 'Nkolafamba' ? 'selected' : '' }}>Nkolafamba</option>
                    <option value="Nkoabang" {{ old('location') == 'Nkoabang' ? 'selected' : '' }}>Nkoabang</option>
                </select>
            </div>

            {{-- Image --}}
            <div class="mb-5">
                <x-label for="image" value="Image de l’événement" class="text-sky-700 font-semibold" />
                <input id="media" name="media[]" type="file" accept="image/*,video/*"
                       class="mt-1 block w-full border border-sky-300 rounded-md p-2
                              focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                              transition duration-300" multiple />
            </div>

            {{-- Boutons --}}
            <div class="flex items-center justify-between mt-4">
                <a href="{{ url('/admin/dashboard#evenements') }}"
                   class="underline text-sm text-sky-600 hover:text-sky-800 rounded-md
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-400">
                    Annuler
                </a>

                <x-button
                  class="bg-sky-600 hover:bg-sky-800 focus:ring-4 focus:ring-sky-300
                         text-white font-bold py-2 px-6 rounded-lg transition transform
                         hover:scale-105 active:scale-95"
                >
                    Créer
                </x-button>
            </div>
        </form>

        {{-- Animation Snake Border --}}
        <style>
            @keyframes snake-border {
              to { background-position: 200% 0; }
            }
            .snake-border {
              position: relative;
              border-radius: 1rem;
              z-index: 0;
            }
            .snake-border::before {
              content: "";
              position: absolute;
              inset: 0;
              padding: 4px;
              border-radius: inherit;
              background:
                  conic-gradient(
                    from 0deg,
                    #84cc16 0deg 20deg,
                    transparent 20deg 40deg,
                    #0ea5e9 40deg 60deg,
                    transparent 60deg 80deg,
                    #84cc16 80deg 100deg
                  );
              -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
              -webkit-mask-composite: destination-out;
              mask-composite: exclude;
              animation: snake-border 3s linear infinite;
              background-size: 200% 100%;
              z-index: -1;
              pointer-events: none;
            }
        </style>
    </div>
</div>
@endsection
