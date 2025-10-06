@extends('layouts.app')

@section('content')
<div class="relative flex flex-col items-center min-h-[calc(100vh-8rem-10rem)] px-4 pt-20">

    {{-- Contenu du formulaire --}}
    <div
      class="relative w-full max-w-md bg-stone-50 bg-opacity-95 rounded-xl shadow-xl p-8 z-10 border-4 border-double border-sky-500 border-r-lime-500 border-t-sky-500 border-b-lime-500 rounded-lg p-6
      style="backdrop-filter: blur(8px);"
    >
        {{-- Logo au-dessus du formulaire --}}
        <div class="flex justify-center mb-6">
            <img src="/images/logotype.png" alt="Logo KDWFoundation" class="w-20 h-auto" />
        </div>

        {{-- Titre "Connexion" --}}
        <h2 class="text-center text-3xl font-bold text-sky-700 mb-8 select-none">Connexion</h2>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 animate-fade-up">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" novalidate
            class="border-4 border-double border-lime-500 border-r-sky-500 border-t-lime-500 border-b-sky-500 rounded-lg p-6">

            @csrf

            {{-- <div class="mb-5">
                <x-label for="username" value="{{ __('Username') }}" class="text-sky-700 font-semibold" />
                <x-input id="username" class="mt-1 block w-full border border-sky-300 rounded-md
                             focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                             transition duration-300"
                         type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            </div> --}}

            <div class="mb-5">
                <x-label for="email" value="{{ __('Email') }}" class="text-sky-700 font-semibold" />
                <x-input id="email" class="mt-1 block w-full border border-sky-300 rounded-md
                             focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                             transition duration-300"
                         type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mb-5">
                <x-label for="password" value="{{ __('Password') }}" class="text-sky-700 font-semibold" />
                <x-input id="password" class="mt-1 block w-full border border-sky-300 rounded-md
                             focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                             transition duration-300"
                         type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="mb-5 flex items-center">
                <x-checkbox id="remember_me" name="remember" />
                <label for="remember_me" class="ml-2 text-gray-700 select-none cursor-pointer text-sm">
                    {{ __('Remember me') }}
                </label>
            </div>

            <div class="mb-5 flex items-center">
               <a class="underline text-sm text-sky-600 hover:text-sky-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-400" href="{{ route('register') }}">
                    {{ __('Not have account?') }}
                </a>
            </div>

            <div class="flex items-center justify-between">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-lime-600 hover:text-lime-800 transition duration-300 underline focus:outline-none focus:ring-2 focus:ring-lime-400 rounded"
                    >
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button
                    class="bg-sky-600 hover:bg-sky-800 focus:ring-4 focus:ring-sky-300
                           text-white font-bold py-2 px-6 rounded-lg transition transform
                           hover:scale-105 active:scale-95"
                >
                    {{ __('Log in') }}
                </x-button>
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
