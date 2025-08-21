@extends('layouts.app')

@section('title', 'Contact - KDWF')

@section('content')
<section class="relative bg-white shadow-2xl rounded-2xl max-w-6xl mx-auto mt-32 overflow-hidden animate-fadeIn">
    <div class="grid md:grid-cols-2">

        <!-- INFO CONTACT -->
        <div class="bg-sky-600 text-white p-10 flex flex-col justify-center transform transition duration-500 hover:scale-105">
            <h2 class="text-4xl font-bold mb-6">Contactez-nous</h2>
            <p class="mb-4 text-lg opacity-90">Vous avez une question, une suggestion ou un besoin de plus d’informations ? Écrivez-nous et notre équipe vous répondra rapidement.</p>
            
            <div class="mt-6 space-y-4">
                <!-- Adresse -->
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-sky-600 font-bold shadow">
                        <!-- Location Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s8-7.5 8-13a8 8 0 10-16 0c0 5.5 8 13 8 13z"/>
                        </svg>
                    </span>
                    <p>Yaounde, Cameroun</p>
                </div>

                <!-- Téléphone -->
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-sky-600 font-bold shadow">
                        <!-- Phone Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.37 4.11a1 1 0 01-.272 1.024l-2.12 2.12a16 16 0 007.548 7.548l2.12-2.12a1 1 0 011.024-.272l4.11 1.37a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </span>
                    <p>+237 6 XX XX XX XX</p>
                </div>

                <!-- Email -->
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-sky-600 font-bold shadow">
                        <!-- Mail Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 100-8 4 4 0 000 8zM8 12a4 4 0 100-8 4 4 0 000 8zm0 0v6m8-6v6"/>
                        </svg>
                    </span>
                    <p>contact@kdwfoundation.org</p>
                </div>
            </div>

            <!-- Réseaux sociaux -->
            <div class="mt-8 flex gap-4">
                <!-- Globe -->
                <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-sky-600 hover:bg-sky-700 hover:text-white transition transform hover:rotate-12 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a8 8 0 100 16 8 8 0 000-16z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12h20M12 2a10 10 0 0110 10M12 22A10 10 0 012 12"/>
                    </svg>
                </a>
                <!-- Facebook -->
                <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-sky-600 hover:bg-sky-700 hover:text-white transition transform hover:rotate-12 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22 12a10 10 0 10-11.5 9.9v-7h-2v-3h2v-2c0-2 1.2-3.1 3-3.1.9 0 1.8.2 1.8.2v2h-1c-1 0-1.3.6-1.3 1.2v1.7h2.5l-.4 3h-2v7A10 10 0 0022 12z"/>
                    </svg>
                </a>
                <!-- Twitter -->
                <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-sky-600 hover:bg-sky-700 hover:text-white transition transform hover:rotate-12 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                    </svg>
                </a>
                <!-- Instagram -->
                <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-sky-600 hover:bg-sky-700 hover:text-white transition transform hover:rotate-12 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm10 2c1.6 0 3 1.4 3 3v10c0 1.6-1.4 3-3 3H7c-1.6 0-3-1.4-3-3V7c0-1.6 1.4-3 3-3h10zm-5 3a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm4.8-2.9a1.2 1.2 0 100 2.4 1.2 1.2 0 000-2.4z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- FORMULAIRE -->
        <div class="p-10 bg-gray-50">
            <form action="#" method="POST" class="space-y-6 animate-fadeIn delay-200">
                
                <!-- Nom complet -->
                <div>
                    <label class="block font-semibold mb-2">Full Name*</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" placeholder="First Name" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-sky-600 shadow-sm">
                        <input type="text" placeholder="Last Name" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-sky-600 shadow-sm">
                    </div>
                </div>

                <!-- Adresse -->
                <div>
                    <label class="block font-semibold mb-2">Address</label>
                    <input type="text" placeholder="Street Address" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-sky-600 mb-3 shadow-sm">
                    <div class="grid grid-cols-3 gap-4">
                        <input type="text" placeholder="City" class="p-3 border rounded-lg focus:ring-2 focus:ring-sky-600 shadow-sm">
                        <input type="text" placeholder="State" class="p-3 border rounded-lg focus:ring-2 focus:ring-sky-600 shadow-sm">
                        <input type="text" placeholder="ZIP Code" class="p-3 border rounded-lg focus:ring-2 focus:ring-sky-600 shadow-sm">
                    </div>
                </div>

                <!-- Contact info -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-2">Email*</label>
                        <input type="email" placeholder="your@email.com" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-sky-600 shadow-sm">
                    </div>
                    <div>
                        <label class="block font-semibold mb-2">Phone</label>
                        <input type="tel" placeholder="+237 ..." class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-sky-600 shadow-sm">
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <label class="block font-semibold mb-2">Message*</label>
                    <textarea rows="4" placeholder="Écrivez votre message..." class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-sky-600 shadow-sm"></textarea>
                </div>

                <!-- Newsletter -->
                <div class="flex items-center">
                    <input type="checkbox" id="newsletter" class="mr-2">
                    <label for="newsletter" class="text-sm">Update me on deals and special offers via email.</label>
                </div>

                <!-- Boutons -->
                <div class="flex justify-between">
                    <a href="/" class="px-6 py-3 text-white bg-gray-600 rounded-lg hover:bg-black transition transform hover:scale-105">Annuler</a>
                    <button type="submit" class="px-6 py-3 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition transform hover:scale-105 shadow">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
