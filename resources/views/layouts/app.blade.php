<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-white shadow mb-6">
        <div class="max-w-4xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">{{ config('app.name', 'Laravel') }}</h1>
            <nav class="space-x-4">
                <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Accueil</a>
                <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">Posts</a>
                <a href="{{ route('posts.create') }}" class="text-blue-600 hover:underline">Créer un Post</a>
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
                <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button type="submit" class="text-red-500 hover:underline">Déconnexion</button>

                </form>
            </nav>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4">
        @yield('content')
    </main>

    <footer class="text-center mt-12 text-sm text-gray-500">
        &copy; {{ date('Y') }} - Propulsé par Laravel & Tailwind 🌀
    </footer>
</body>
</html>
