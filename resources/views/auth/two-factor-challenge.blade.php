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
        <h2 class="text-center text-3xl font-bold text-sky-700 mb-8 select-none">Authentification à deux facteurs</h2>

        <div x-data="{ recovery: false }">
            <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            <div class="mb-4 text-sm text-gray-600" x-cloak x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            {{-- Validation Errors --}}
            <x-validation-errors class="mb-4" />

            {{-- Formulaire --}}
            <form method="POST" action="{{ route('two-factor.login') }}" novalidate>
                @csrf

                <div class="mb-5" x-show="! recovery">
                    <x-label for="code" value="{{ __('Code') }}" class="text-sky-700 font-semibold" />
                    <x-input id="code" class="mt-1 block w-full border border-sky-300 rounded-md
                                 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                                 transition duration-300"
                             type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                </div>

                <div class="mb-5" x-cloak x-show="recovery">
                    <x-label for="recovery_code" value="{{ __('Recovery Code') }}" class="text-sky-700 font-semibold" />
                    <x-input id="recovery_code" class="mt-1 block w-full border border-sky-300 rounded-md
                                 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                                 transition duration-300"
                             type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                    x-show="! recovery"
                                    x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ __('Use a recovery code') }}
                    </button>

                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                    x-cloak
                                    x-show="recovery"
                                    x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ __('Use an authentication code') }}
                    </button>

                    <x-button class="ms-4 bg-sky-600 hover:bg-sky-800 focus:ring-4 focus:ring-sky-300
                                   text-white font-bold py-2 px-6 rounded-lg transition transform
                                   hover:scale-105 active:scale-95">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
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
