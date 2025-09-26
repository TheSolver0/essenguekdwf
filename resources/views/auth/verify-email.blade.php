@extends('layouts.app')

@section('content')
<div class="relative flex flex-col items-center min-h-[calc(100vh-8rem-10rem)] px-4 pt-20">

    {{-- Conteneur du formulaire avec bordure double colorée et effet blur --}}
    <div 
      class="relative w-full max-w-md bg-stone-50 bg-opacity-95 rounded-xl shadow-xl p-8 z-10
             border-4 border-double border-lime-500 border-r-sky-500 border-t-lime-500 border-b-sky-500
             backdrop-blur-md
             rounded-lg p-6"
    >
        {{-- Logo au-dessus du formulaire --}}
        <div class="flex justify-center mb-6">
            <img src="/images/logotype.png" alt="Logo KDWFoundation" class="w-20 h-auto" />
        </div>

        {{-- Titre --}}
        <h2 class="text-center text-3xl font-bold text-sky-700 mb-8 select-none">Mot de passe oublié</h2>

        {{-- Message explicatif --}}
        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        {{-- Message de statut (success) --}}
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 animate-fade-up text-center">
                {{ session('status') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        <x-validation-errors class="mb-4" />

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('password.email') }}" novalidate>
            @csrf

            <div class="mb-5">
                <x-label for="email" value="{{ __('Email') }}" class="text-sky-700 font-semibold" />
                <x-input id="email" class="mt-1 block w-full border border-sky-300 rounded-md
                             focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                             transition duration-300"
                         type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="bg-sky-600 hover:bg-sky-800 focus:ring-4 focus:ring-sky-300
                               text-white font-bold py-2 px-6 rounded-lg transition transform
                               hover:scale-105 active:scale-95">
                    {{ __('Email Password Reset Link') }}
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
