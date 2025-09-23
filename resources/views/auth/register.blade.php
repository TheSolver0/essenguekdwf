@extends('layouts.app')

@section('content')
<div class="relative flex flex-col items-center min-h-[calc(100vh-8rem-10rem)] px-4 pt-20">
    <div
      class="relative w-full max-w-md bg-stone-50 bg-opacity-95 rounded-xl shadow-xl p-8 z-10
             border-4 border-double border-sky-500 border-r-lime-500 border-t-sky-500 border-b-lime-500
             rounded-lg p-6"
      style="backdrop-filter: blur(8px);"
    >
        {{-- Logo au-dessus du formulaire --}}
        <div class="flex justify-center mb-6">
            <img src="/images/logotype.png" alt="Logo KDWFoundation" class="w-20 h-auto" />
        </div>

        {{-- Titre "Inscription" --}}
        <h2 class="text-center text-3xl font-bold text-sky-700 mb-8 select-none">Inscription</h2>

        <x-validation-errors class="mb-4" />

       <form method="POST" action="{{ route('register') }}" novalidate
            class="snake-border bg-stone-50 bg-opacity-95 rounded-lg p-6 relative"
            style="backdrop-filter: blur(8px);">
            @csrf

            <div class="mb-5">
                <x-label for="name" value="{{ __('Name') }}" class="text-sky-700 font-semibold" />
                <x-input id="name" class="mt-1 block w-full border border-sky-300 rounded-md
                             focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                             transition duration-300"
                         type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <!--div class="mb-5">
                <x-label for="username" value="{{ __('Username') }}" class="text-sky-700 font-semibold" />
                <x-input id="username" class="mt-1 block w-full border border-sky-300 rounded-md
                             focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                             transition duration-300"
                         type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            </!--div-->

           <div class="mb-5">
                <x-label for="email" value="{{ __('Email') }}" class="text-sky-700 font-semibold" />
                <x-input id="email" class="mt-1 block w-full border border-sky-300 rounded-md
                            focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                            transition duration-300"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                <p id="emailFeedback" class="text-sm mt-1"></p>
            </div>

            <div class="mb-5">
                <x-label for="password" value="{{ __('Password') }}" class="text-sky-700 font-semibold" />
                <x-input id="password" class="mt-1 block w-full border border-sky-300 rounded-md
                            focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                            transition duration-300"
                        type="password" name="password" required autocomplete="new-password" />
                <p id="passwordStrength" class="text-sm mt-1 font-semibold"></p>
            </div>

            <div class="mb-5">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-sky-700 font-semibold" />
                <x-input id="password_confirmation" class="mt-1 block w-full border border-sky-300 rounded-md
                            focus:outline-none focus:ring-2 focus:ring-lime-400 focus:border-lime-400
                            transition duration-300"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mb-5">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2 text-gray-700 text-sm leading-tight">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sky-600 hover:text-sky-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-400">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sky-600 hover:text-sky-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-400">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-between mt-4">
                <a class="underline text-sm text-sky-600 hover:text-sky-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-400" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button
                  class="bg-sky-600 hover:bg-sky-800 focus:ring-4 focus:ring-sky-300
                         text-white font-bold py-2 px-6 rounded-lg transition transform
                         hover:scale-105 active:scale-95"
                >
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
        <style>
            @keyframes snake-border {
            to {
                background-position: 200% 0;
            }
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
            padding: 4px; /* épaisseur bordure */
            border-radius: inherit;
            background:
                conic-gradient(
                from 0deg,
                #84cc16 0deg 20deg,       /* lime-500 (serpent color) */
                transparent 20deg 40deg,  /* gap */
                #0ea5e9 40deg 60deg,      /* sky-500 */
                transparent 60deg 80deg,
                #84cc16 80deg 100deg
                );
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: destination-out;
            mask-composite: exclude;
            animation: snake-border 3s linear infinite;
            background-size: 200% 100%;
            z-index: -1;
            pointer-events: none;
            }

        </style>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const emailInput = document.getElementById('email');
                const emailFeedback = document.getElementById('emailFeedback');

                const passwordInput = document.getElementById('password');
                const passwordStrength = document.getElementById('passwordStrength');

                function validateEmail(email) {
                    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return re.test(email);
                }

                function checkPasswordStrength(password) {
                    let strength = 0;
                    if (password.length >= 8) strength++;
                    if (/[A-Z]/.test(password)) strength++;
                    if (/[a-z]/.test(password)) strength++;
                    if (/\d/.test(password)) strength++;
                    if (/[\W_]/.test(password)) strength++;

                    if (strength <= 2) return { text: 'Faible', color: 'text-red-600' };
                    if (strength === 3 || strength === 4) return { text: 'Moyen', color: 'text-yellow-500' };
                    if (strength === 5) return { text: 'Fort', color: 'text-green-600' };
                }

                emailInput.addEventListener('input', () => {
                    const email = emailInput.value;
                    if (!email) {
                        emailFeedback.textContent = '';
                        emailFeedback.className = 'text-sm mt-1';
                        return;
                    }
                    if (validateEmail(email)) {
                        emailFeedback.textContent = 'Email valide 👍';
                        emailFeedback.className = 'text-sm mt-1 text-green-600';
                    } else {
                        emailFeedback.textContent = 'Format email invalide ❌';
                        emailFeedback.className = 'text-sm mt-1 text-red-600';
                    }
                });

                passwordInput.addEventListener('input', () => {
                    const password = passwordInput.value;
                    if (!password) {
                        passwordStrength.textContent = '';
                        passwordStrength.className = 'text-sm mt-1 font-semibold';
                        return;
                    }
                    const strength = checkPasswordStrength(password);
                    passwordStrength.textContent = `Force : ${strength.text}`;
                    passwordStrength.className = `text-sm mt-1 font-semibold ${strength.color}`;
                });
            });
        </script>
    </div>
</div>
@endsection
