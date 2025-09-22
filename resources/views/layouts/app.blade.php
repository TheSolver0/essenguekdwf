<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KDWFoundation</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <link rel="icon" type="image/png" href="/images/favicon.png">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-white text-gray-800 font-sans">

<header class="bg-stone-50 shadow fixed top-0 left-0 w-full z-50">
  <div class="flex flex-col md:flex-row">
    <!-- Logo -->
    <div class="flex items-center justify-center px-4 h-36 md:h-48 border-r border-stone-50">
      <img src="{{ asset('images/logotype.png') }}" alt="Logo KDWFoundation" class="h-28 md:h-44 w-auto">
    </div>

    <!-- Titre + Nav -->
    <div class="flex-1 flex flex-col h-36 md:h-48">
      <!-- Titre + décorations -->
      <div class="relative flex flex-col items-center h-36 md:h-48 py-4 md:py-6 border-b-2 border-green-400 bg-stone-50">
        <div class="absolute top-2 md:top-4 left-1/2 transform -translate-x-1/2 w-2/3 md:w-2/3 h-1 md:h-2 bg-pink-500 rounded-full"></div>
        <h1 class="text-2xl sm:text-3xl md:text-5xl font-extrabold text-sky-600 text-center tracking-wide drop-shadow-lg px-2 md:px-0">
          KING'S DREAM WORLD FOUNDATION
        </h1>
        <div class="absolute bottom-2 md:bottom-4 left-1/2 transform -translate-x-1/2 w-2/3 md:w-2/3 h-1 md:h-2 bg-pink-500 rounded-full"></div>
      </div>

      <!-- Navigation -->
      <nav class="bg-lime-600 flex items-center justify-between px-4 md:px-6 py-2 md:py-3 rounded-b-[50px] relative">
        <!-- Menu mobile -->
        <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>

        <!-- Liens -->
        <div id="mobile-menu" class="navbar hidden flex-col md:flex md:flex-row md:gap-6 w-full md:w-auto text-white mt-2 md:mt-0">
          <a href="{{ url('/') }}" class="block md:inline-block px-2 py-1 hover:underline {{ request()->is('/') ? 'underline' : '' }}">Accueil</a>
          <a href="{{ url('/about') }}" class="block md:inline-block px-2 py-1 hover:underline {{ request()->is('about') ? 'underline' : '' }}">Qui sommes-nous</a>
          <a href="{{ url('/activity') }}" class="block md:inline-block px-2 py-1 hover:underline {{ request()->is('activity') ? 'underline' : '' }}">Actualité</a>
          <a href="{{ url('/mediatheque') }}" class="block md:inline-block px-2 py-1 hover:underline {{ request()->is('mediatheque') ? 'underline' : '' }}">Médiathèque</a>
          <a href="{{ url('/implantation') }}" class="block md:inline-block px-2 py-1 hover:underline {{ request()->is('implantation') ? 'underline' : '' }}">Implantation</a>
          <a href="{{ url('/contact') }}" class="block md:inline-block px-2 py-1 hover:underline {{ request()->is('contact') ? 'underline' : '' }}">Contact</a>
        </div>

        <!-- Compte + Don -->
        <div class="flex items-center gap-2 md:gap-4 mt-2 md:mt-0">
          <!-- Compte -->
          <div class="relative inline-block text-left font-[Great Vibes] text-sm md:text-lg">
              <button type="button" class="flex items-center gap-2 text-white hover:bg-black rounded-lg px-2 py-1 md:px-3 md:py-1 duration-500 focus:outline-none"
                  onclick="document.getElementById('account-menu').classList.toggle('hidden')">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 md:h-6 w-5 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9.003 9.003 0 0112 15c2.21 0 4.21.805 5.879 2.121M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                  <span class="navbar">Compte</span>
              </button>

              <div id="account-menu" class="navbar hidden absolute right-0 mt-2 w-36 md:w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                  @auth
                      <!-- Si l'utilisateur est connecté -->
                      <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" 
                        class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">
                        {{ auth()->user()->username }}
                      </a>

                      <form action="{{ route('logout') }}" method="POST">
                          @csrf
                          <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-500 hover:bg-gray-100">
                              Déconnexion
                          </button>
                      </form>
                  @else
                      <!-- Si aucun utilisateur connecté -->
                      <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">Connexion</a>
                      <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">Inscription</a>
                  @endauth
              </div>
          </div>

          <a href="{{ url('/donate') }}" class="bg-sky-600 text-white px-3 py-1 md:px-4 md:py-2 rounded-md font-bold text-xs md:text-sm shadow-md hover:bg-blue-700 text-center leading-tight">
            Je Fais<br><span class="navbar text-lg md:text-xl">DON</span>
          </a>
        </div>
      </nav>
    </div>
  </div>
</header>

<main class="min-h-screen pt-28 px-4 sm:px-6 md:px-12">
  @yield('content')
</main>

<footer class="bg-sky-900 text-white py-10 px-4 sm:px-6 md:px-12 mt-12">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- À propos -->
    <div>
      <h4 class="text-lg font-semibold mb-4">À propos</h4>
      <p class="text-gray-300 leading-relaxed">
        KDWFoundation œuvre pour un avenir meilleur pour les jeunes en difficulté à travers des projets éducatifs et solidaires.
      </p>
    </div>
    <!-- Liens utiles -->
    <div>
      <h4 class="text-lg font-semibold mb-4">Liens utiles</h4>
      <ul class="space-y-2">
        <li><a href="{{ url('/') }}" class="hover:underline">Accueil</a></li>
        <li><a href="{{ url('/projects') }}" class="hover:underline">Projets</a></li>
        <li><a href="{{ url('/donate') }}" class="hover:underline">Faire un don</a></li>
        <li><a href="{{ url('/contact') }}" class="hover:underline">Contact</a></li>
      </ul>
    </div>
    <!-- Réseaux sociaux -->
    <div>
      <h4 class="text-lg font-semibold mb-4">Suivez-nous</h4>
      <div class="flex flex-col space-y-2">
        <a href="#" aria-label="Facebook" class="hover:underline">Facebook</a>
        <a href="#" aria-label="Instagram" class="hover:underline">Instagram</a>
        <a href="#" aria-label="LinkedIn" class="hover:underline">LinkedIn</a>
      </div>
    </div>
  </div>

  <div class="border-t border-gray-700 mt-8 pt-4 text-center text-sm text-gray-400">
    &copy; {{ date('Y') }} KDWFoundation. Tous droits réservés.
  </div>
</footer>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<script>
AOS.init({ duration:800, easing:'ease-in-out', once:true });

// Menu mobile
document.getElementById('mobile-menu-button').addEventListener('click', function(){
  const menu = document.getElementById('mobile-menu');
  menu.classList.toggle('hidden');
});
</script>

</body>
</html>
