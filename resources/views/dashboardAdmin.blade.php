@extends('layouts.app')

@section('content')
{{-- Empêche le flash des éléments x-show au chargement --}}
<style>[x-cloak]{ display:none !important; }</style>

<div x-data="dashboard()" x-init="init()" class="min-h-screen bg-gray-50">
    {{-- Layout avec header déjà présent dans app.blade.php (probablement fixed). On laisse un padding-top. --}}
    <div class="pt-20">
        <div class="flex">
            {{-- Sidebar FIXE sous le header --}}
            <aside class="sticky top-20 h-[calc(100vh-5rem)] w-64 bg-blue-600 text-white flex-shrink-0">

                <div class="p-6 text-2xl font-bold">KDWF</div>
                <nav class="h-[calc(100%-6rem)] overflow-y-auto px-2 pb-6">
                    <ul class="space-y-1">
                        <template x-for="menu in menus" :key="menu.tab">
                            <li>
                                <a href="#" @click.prevent="setTab(menu.tab)"
                                   class="flex items-center px-4 py-2 rounded transition"
                                   :class="tab === menu.tab ? 'bg-blue-500/80' : 'hover:bg-blue-500/40'">
                                    <span x-text="menu.name"></span>
                                    <template x-if="menu.badge && menu.badge > 0">
                                        <span class="ml-2 inline-block w-5 h-5 text-xs bg-red-600 text-white rounded-full text-center align-middle font-bold" x-text="menu.badge"></span>
                                    </template>
                                </a>
                            </li>
                        </template>
                    </ul>
                </nav>
            </aside>

        {{-- Zone de contenu --}}
        <main
            class="flex-1 md:ml-64 w-full md:w-[calc(100%-16rem)] min-h-[calc(100vh-5rem)]">
            <div class="relative h-[calc(100vh-5rem)] overflow-hidden">
                {{-- ================= Accueil ================= --}}
                <section x-show="tab === 'accueil'" x-cloak
                    class="absolute inset-0 overflow-y-auto px-4 sm:px-6 md:px-10 pb-10"
                    x-transition:enter="transition duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">

                    {{-- Header --}}
                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                        <h1
                            class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800">
                            Dashboard — Accueil</h1>
                        <a href="{{ route('posts.create') }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Créer un post
                        </a>
                    </div>

                    {{-- Cartes statistiques --}}
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-2xl shadow">
                            <a href="{{ route('admin.users.index') }}"
                                class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-300 block">
                                <h2 class="text-sm font-semibold text-gray-500">Total
                                    utilisateurs</h2>
                                <p
                                    class="mt-2 text-2xl sm:text-3xl font-bold text-emerald-600">
                                    {{ $totalUsers }}</p>
                            </a>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow">
                            <h2 class="text-sm font-semibold text-gray-500">Dons reçus</h2>
                            <p
                                class="mt-2 text-2xl sm:text-3xl font-bold text-sky-600">
                                {{ $totalDonations ?? '5 482 €' }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow">
                            <h2 class="text-sm font-semibold text-gray-500">Nouveaux messages</h2>
                            
                            {{-- Nombre total --}}
                            <p class="mt-2 text-2xl sm:text-3xl font-bold text-rose-600">
                                {{ $newMessages }}
                            </p>

                            {{-- Liste des noms des expéditeurs --}}
                            @if($newMessages > 0)
                                <ul class="mt-3 text-sm text-gray-700 space-y-1">
                                    @foreach($unreadSenders as $sender)
                                        <li>📩 {{ $sender->prenom }} {{ $sender->nom }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-3 text-xs text-gray-400">Aucun nouveau message</p>
                            @endif
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow">
                            <h2 class="text-sm font-semibold text-gray-500">Activités
                                récentes</h2>
                            <p
                                class="mt-2 text-2xl sm:text-3xl font-bold text-gray-700">
                                {{ $recentActivities ?? 21 }}</p>
                        </div>
                    </div>

                    {{-- Graphique (unique) --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-2xl shadow h-80">
                            <h3 class="text-lg font-semibold mb-4">Interactions (Mensuel)</h3>
                            <canvas id="statsChart" class="w-full h-full"></canvas>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow h-80">
                            <h3 class="text-lg font-semibold mb-4">Croissance utilisateurs</h3>
                            <canvas id="usersChart" class="w-full h-full"></canvas>
                        </div>
                    </div>

                    {{-- Tables récentes --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Posts récents --}}
                        <div class="bg-white p-6 rounded-2xl shadow">
                            <h3 class="text-lg font-semibold mb-4">Posts récents</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Titre</th>
                                            <th class="px-4 py-2 text-left">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($posts as $post)
                                            <tr class="border-b last:border-0">
                                                <td class="px-4 py-2 font-medium">
                                                    {{ $post->title }}</td>
                                                <td class="px-4 py-2 text-gray-600">
                                                    {{ $post->created_at->format('d/m/Y') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2"
                                                    class="px-4 py-6 text-center text-gray-500">
                                                    Aucun post</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Notifications (exemple) --}}
                        <div class="bg-white p-6 rounded-2xl shadow">
                            <h3 class="text-lg font-semibold mb-4">Notifications récentes
                            </h3>
                            <ul class="space-y-3">
                                @forelse(($notifications ?? []) as $n)
                                    <li class="flex items-start gap-3">
                                        <span
                                            class="mt-1 h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                                        <div>
                                            <p class="text-sm">{{ $n->title ?? 'Notification' }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $n->created_at?->diffForHumans() }}</p>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-sm text-gray-500">Aucune notification</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- ================= Posts ================= --}}
                <section x-show="tab === 'posts'" x-cloak
                        class="absolute inset-0 overflow-y-auto px-4 sm:px-6 md:px-10 pb-10"
                        x-transition:enter="transition duration-300"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800">Activités / Posts</h1>
                        <a href="{{ route('posts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 text-sm sm:text-base">Créer un post</a>
                    </div>

                    <div class="border rounded-2xl shadow overflow-hidden">
                        <div class="max-h-[60vh] overflow-y-auto overflow-x-auto">
                            <table class="min-w-full text-sm bg-white">
                                <thead class="bg-gray-100 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Titre</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Auteur</th>
                                        <th class="px-4 py-2 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($posts as $post)
                                    <tr class="border-b last:border-0" x-data="{ openEdit:false, openDelete:false }">
                                        <td class="px-4 py-2 font-semibold">{{ $post->title }}</td>
                                        <td class="px-4 py-2 text-gray-600">{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-2 text-gray-600">{{ $post->user->name ?? 'Inconnu' }}</td>
                                        <td class="px-4 py-2">
                                            <div class="flex flex-wrap gap-2">
                                                <button @click="openEdit=true" class="px-3 py-1 bg-lime-600 text-white rounded hover:bg-lime-700 text-sm">Modifier</button>
                                                <button @click="openDelete=true" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Supprimer</button>
                                            </div>

                                            {{-- Modal Edit Post --}}
                                            <div x-show="openEdit" x-cloak x-transition
                                                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 p-4">
                                                <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative">
                                                    <h2 class="text-lg sm:text-xl font-semibold mb-4">Modifier le post</h2>
                                                    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-4">
                                                            <label class="block text-sm font-medium text-gray-700">Titre</label>
                                                            <input type="text" name="title" value="{{ $post->title }}" class="mt-1 w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="block text-sm font-medium text-gray-700">Description</label>
                                                            <textarea name="body" rows="4" class="mt-1 w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('body', $post->body) }}</textarea>
                                                        </div>

                                                        {{-- Médias existants --}}
                                                        @if($post->media && $post->media->count())
                                                            <div class="mb-4">
                                                                <label class="block text-sm font-medium text-gray-700 mb-2">Médias actuels</label>
                                                                <div class="flex flex-wrap gap-3">
                                                                    @foreach($post->media as $media)
                                                                        <label class="relative w-24 h-24">
                                                                            @if($media->media_type === 'image')
                                                                                <img src="{{ $media->media_url }}" class="w-full h-full object-cover rounded-lg border">
                                                                            @else
                                                                                <video src="{{ $media->media_url }}" class="w-full h-full rounded-lg border" muted controls></video>
                                                                            @endif
                                                                            <input type="checkbox" name="delete_media[]" value="{{ $media->id }}" class="absolute top-2 right-2 h-4 w-4">
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                                <p class="mt-2 text-xs text-gray-500">Cochez pour supprimer.</p>
                                                            </div>
                                                        @endif

                                                        <div class="mb-6">
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Ajouter des médias</label>
                                                            <input type="file" name="media[]" multiple class="w-full">
                                                        </div>

                                                        <div class="flex flex-col sm:flex-row justify-end gap-2">
                                                            <button type="button" @click="openEdit=false" class="px-3 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Annuler</button>
                                                            <button type="submit" class="px-3 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600">Enregistrer</button>
                                                        </div>
                                                    </form>
                                                    <button @click="openEdit=false" class="absolute top-3 right-3 text-xl leading-none">&times;</button>
                                                </div>
                                            </div>

                                            {{-- Modal Delete Post --}}
                                            <div x-show="openDelete" x-cloak x-transition
                                                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 p-4">
                                                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">
                                                    <h2 class="text-lg font-semibold mb-2">Confirmer la suppression</h2>
                                                    <p class="text-sm text-gray-600 mb-4">Voulez-vous vraiment supprimer ce post ? Cette action est irréversible.</p>
                                                    <div class="flex justify-end gap-2">
                                                        <button @click="openDelete=false" class="px-3 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Annuler</button>
                                                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Confirmer</button>
                                                        </form>
                                                    </div>
                                                    <button @click="openDelete=false" class="absolute top-3 right-3 text-xl leading-none">&times;</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Aucun post</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {{-- ================= Événements ================= --}}
                <section x-show="tab === 'evenements'" x-cloak
                        class="absolute inset-0 overflow-y-auto px-4 sm:px-6 md:px-10 pb-10"
                        x-transition:enter="transition duration-300"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800">Événements</h1>
                        <a href="{{ route('events.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 text-sm sm:text-base">Créer un événement</a>
                    </div>

                    <div class="border rounded-2xl shadow overflow-hidden">
                        <div class="max-h-[60vh] overflow-y-auto overflow-x-auto">
                            <table class="min-w-full text-sm bg-white">
                                <thead class="bg-gray-100 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Titre</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Lieu</th>
                                        <th class="px-4 py-2 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($events as $event)
                                    <tr class="border-b last:border-0" x-data="{ openEdit:false, openDelete:false }">
                                        <td class="px-4 py-2 font-semibold">{{ $event->title }}</td>
                                        <td class="px-4 py-2 text-gray-600">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2 text-gray-600">{{ $event->location }}</td>
                                        <td class="px-4 py-2">
                                            <div class="flex flex-wrap gap-2">
                                                <button @click="openEdit=true" class="px-3 py-1 bg-lime-600 text-white rounded hover:bg-lime-700 text-sm">Modifier</button>
                                                <button @click="openDelete=true" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Supprimer</button>
                                            </div>

                                            {{-- Modal Edit Event --}}
                                            <div x-show="openEdit" x-cloak x-transition
                                                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 p-4">
                                                <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative">
                                                    <h2 class="text-lg sm:text-xl font-semibold mb-4">Modifier l’événement</h2>
                                                    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <label class="block text-sm font-medium text-gray-700">Titre</label>
                                                                <input type="text" name="title" value="{{ $event->title }}" class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-400">
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                                                <input type="date" name="date" value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}" class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-400">
                                                            </div>
                                                            <div class="md:col-span-2">
                                                                <label class="block text-sm font-medium text-gray-700">Lieu</label>
                                                                <input type="text" name="location" value="{{ $event->location }}" class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-400">
                                                            </div>
                                                            <div class="md:col-span-2">
                                                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                                                <textarea name="description" rows="4" class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-400">{{ old('description', $event->description) }}</textarea>
                                                            </div>
                                                            <div class="md:col-span-2">
                                                                <label class="block text-sm font-medium text-gray-700">Image</label>
                                                                <input type="file" name="image" class="w-full">
                                                                @if($event->image)
                                                                    <img src="{{ $event->image }}" alt="Event image" class="w-24 h-24 mt-2 rounded-lg object-cover border">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="mt-6 flex flex-col sm:flex-row justify-end gap-2">
                                                            <button type="button" @click="openEdit=false" class="px-3 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Annuler</button>
                                                            <button type="submit" class="px-3 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600">Enregistrer</button>
                                                        </div>
                                                    </form>
                                                    <button @click="openEdit=false" class="absolute top-3 right-3 text-xl leading-none">&times;</button>
                                                </div>
                                            </div>

                                            {{-- Modal Delete Event --}}
                                            <div x-show="openDelete" x-cloak x-transition
                                                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 p-4">
                                                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">
                                                    <h2 class="text-lg font-semibold mb-2">Confirmer la suppression</h2>
                                                    <p class="text-sm text-gray-600 mb-4">Voulez-vous vraiment supprimer cet événement ?</p>
                                                    <div class="flex justify-end gap-2">
                                                        <button @click="openDelete=false" class="px-3 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Annuler</button>
                                                        <form action="{{ route('events.destroy', $event) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Confirmer</button>
                                                        </form>
                                                    </div>
                                                    <button @click="openDelete=false" class="absolute top-3 right-3 text-xl leading-none">&times;</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Aucun événement trouvé</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {{-- ================= Médiathèque ================= --}}
                <section x-show="tab === 'medias'" x-cloak
                        class="absolute inset-0 overflow-y-auto px-2 sm:px-6 md:px-10 pb-10"
                        x-transition:enter="transition duration-300"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">📂 Médiathèque</h1>
                        <a href="{{ route('admin.medias.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 text-center">
                        Uploader
                        </a>
                    </div>

                    <div class="border rounded-2xl shadow overflow-hidden">
                        <div class="max-h-[70vh] overflow-x-auto">
                            <table class="min-w-full text-sm bg-white">
                                <thead class="bg-gray-100 sticky top-0 z-10 text-xs sm:text-sm">
                                    <tr>
                                        <th class="px-2 sm:px-4 py-2 text-left">Aperçu</th>
                                        <th class="px-2 sm:px-4 py-2 text-left">Nom</th>
                                        <th class="px-2 sm:px-4 py-2 text-left">Catégorie</th>
                                        <th class="px-2 sm:px-4 py-2 text-left">Expiration</th>
                                        <th class="px-2 sm:px-4 py-2 text-left">Statut</th>
                                        <th class="px-2 sm:px-4 py-2 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($medias as $media)
                                    <tr class="border-b last:border-0">
                                        {{-- Aperçu --}}
                                        <td class="px-2 sm:px-4 py-2">
                                            @if(Str::contains($media->media_type, 'image'))
                                                <img src="{{ $media->media_url }}" class="w-12 h-12 sm:w-16 sm:h-16 object-cover rounded-lg border">
                                            @elseif(Str::contains($media->media_type, 'video'))
                                                <video src="{{ $media->media_url }}" class="w-12 h-12 sm:w-16 sm:h-16 rounded-lg border" muted></video>
                                            @else
                                                <span class="px-2 py-1 text-xs bg-gray-200 rounded">Fichier</span>
                                            @endif
                                        </td>

                                        {{-- Infos --}}
                                        <td class="px-2 sm:px-4 py-2 font-medium truncate">{{ $media->nom }}</td>
                                        <td class="px-2 sm:px-4 py-2 text-gray-600">{{ $media->category ?? '-' }}</td>
                                        <td class="px-2 sm:px-4 py-2 text-gray-600">
                                            {{ $media->date_expiration?->format('d/m/Y') ?? '—' }}
                                        </td>
                                        <td class="px-2 sm:px-4 py-2">
                                            @if($media->archived)
                                                <span class="px-2 py-1 text-xs rounded bg-gray-400 text-white">Archivé</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded bg-emerald-500 text-white">Actif</span>
                                            @endif
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-2 sm:px-4 py-2">
                                            <div class="flex flex-wrap gap-2">
                                                @if(!$media->archived)
                                                    <form action="{{ route('admin.medias.extend', $media) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-lime-600 text-white rounded hover:bg-lime-700 text-xs sm:text-sm">
                                                            Prolonger
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.medias.destroy', $media) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs sm:text-sm">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Aucun média trouvé</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {{-- ================= Contact ================= --}}
                <section x-show="tab === 'contact'" x-cloak
                        class="absolute inset-0 overflow-y-auto px-2 sm:px-6 md:px-10 pb-10"
                        x-data="{ selectedMessage: null, readMessages: [] }"
                        x-transition:enter="transition duration-300"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">

                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">📬 Messages de contact</h1>

                    <div class="flex flex-col md:flex-row h-[70vh] border rounded-2xl shadow overflow-hidden bg-white">
                        {{-- Sidebar messages --}}
                        <div class="w-full md:w-1/3 border-r overflow-y-auto">
                            @foreach($contactMessages as $msg)
                            <div 
                                @click="
                                    selectedMessage = {{ $msg->id }};
                                    if (!readMessages.includes({{ $msg->id }}) && {{ $msg->lu ? 'false' : 'true' }}) {
                                        fetch('{{ route('admin.contact.markRead', $msg) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json',
                                            }
                                        }).then(() => {
                                            readMessages.push({{ $msg->id }});
                                        });
                                    }
                                "
                                class="p-4 cursor-pointer hover:bg-gray-100 border-b flex flex-col"
                                :class="{'bg-blue-50': selectedMessage === {{ $msg->id }}}">

                                <div class="flex justify-between items-center">
                                    <span class="font-semibold">{{ $msg->prenom }} {{ $msg->nom }}</span>
                                    <span class="text-xs text-gray-500">{{ $msg->created_at->format('d/m/Y') }}</span>
                                </div>
                                <span class="text-xs text-gray-600 truncate">{{ $msg->message }}</span>
                                <template x-if="!readMessages.includes({{ $msg->id }}) && {{ $msg->lu ? 'false' : 'true' }}">
                                    <span class="text-[10px] text-white bg-blue-500 px-1 rounded self-start mt-1">Nouveau</span>
                                </template>
                            </div>
                            @endforeach
                        </div>

                        {{-- Détail du message --}}
                        <div class="flex-1 relative">
                            <template x-if="selectedMessage">
                                <div class="p-4 sm:p-6 h-full flex flex-col">
                                    {{-- Bouton retour mobile --}}
                                    <button @click="selectedMessage = null" 
                                        class="md:hidden mb-4 text-sm px-3 py-1 bg-gray-200 rounded w-fit">
                                        ← Retour
                                    </button>

                                    @foreach($contactMessages as $msg)
                                    <div x-show="selectedMessage === {{ $msg->id }}" class="flex flex-col h-full">
                                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">
                                            Message de {{ $msg->prenom }} {{ $msg->nom }}
                                        </h2>
                                        <p class="text-xs sm:text-sm text-gray-500 mb-4">
                                            📧 {{ $msg->email }} | 📱 {{ $msg->telephone }}
                                        </p>
                                        <div class="flex-1 overflow-y-auto bg-gray-50 p-3 sm:p-4 rounded-lg text-gray-700 whitespace-pre-line text-sm">
                                            {{ $msg->message }}
                                        </div>

                                        <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                                            <span class="text-xs text-gray-400">Reçu le {{ $msg->created_at->format('d/m/Y H:i') }}</span>
                                            <span class="text-xs" 
                                                :class="readMessages.includes({{ $msg->id }}) || {{ $msg->lu ? 'true' : 'false' }} ? 'text-green-600' : 'text-blue-600'">
                                                <template x-if="readMessages.includes({{ $msg->id }}) || {{ $msg->lu ? 'true' : 'false' }}">
                                                    ✔ Déjà lu
                                                </template>
                                            </span>
                                        </div>

                                        {{-- Boutons actions --}}
                                        <div class="mt-6 flex justify-end gap-3">
                                            <form method="POST" action="{{ route('admin.contact.destroy', $msg) }}" 
                                                onsubmit="return confirm('Voulez-vous vraiment supprimer ce message ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                                                    🗑 Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </template>

                            {{-- Placeholder --}}
                            <div x-show="!selectedMessage" class="flex items-center justify-center h-full text-gray-400 text-sm sm:text-base">
                                Sélectionne un message pour le lire 📩
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </main>
    </div>


@if(session('media_success'))
    <div 
        x-data="{ show:true }"
        x-show="show"
        x-init="setTimeout(()=>show=false,2000)"
        x-transition:leave="transition duration-500 ease-in"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        class="fixed top-10 left-1/2 -translate-x-1/2 z-[9999] bg-emerald-500 text-white px-6 md:px-8 py-3 md:py-4 rounded-2xl shadow-2xl text-sm md:text-xl font-bold flex items-center gap-3 max-w-[90%] sm:max-w-md"
        aria-live="polite"
    >
        <i class="fa fa-check-circle text-lg md:text-3xl"></i>
        <span>{{ session('media_success') }}</span>
    </div>
@endif

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    function dashboard(){
        return {
            tab: '{{ session('tab', 'accueil') }}',
            menus: [
                { name:'Accueil / Vue générale', tab:'accueil' },
                { name:'Activités / Posts', tab:'posts' },
                { name:'Événements', tab:'evenements' },
                { name:'Médias', tab:'medias' },
                { name:'Contact / Messages', tab:'contact', badge: {{ $contactMessages->where('lu', false)->count() }} },
                { name:'Dons & Finances', tab:'dons', disabled:true },
                { name:'Utilisateurs', tab:'utilisateurs', disabled:true },
                { name:'Modération', tab:'moderation', disabled:true },
                { name:'Implantations', tab:'implantations', disabled:true }, 
                { name:'Newsletter', tab:'newsletter', disabled:true },
                { name:'Badges / Ambassadeurs', tab:'badges', disabled:true },
                { name:'Notifications', tab:'notifications', disabled:true },
            ],
            init(){
                // Tab depuis l’ancre
                const hash = window.location.hash.replace('#','');
                if(hash){ this.tab = hash; }
                window.addEventListener('hashchange', () => {
                    const h = window.location.hash.replace('#','');
                    if(h){ this.tab = h; }
                });

                // Charts
                const ctx1 = document.getElementById('statsChart')?.getContext('2d');
                if(ctx1){
                    new Chart(ctx1, {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Fév', 'Mar', 'Avr'],
                            datasets: [{
                                label: 'Interactions',
                                data: [12, 19, 3, 5],
                                backgroundColor: 'rgba(14,165,233,0.5)',
                                borderColor: 'rgb(14,165,233)',
                                borderWidth: 1
                            }]
                        },
                        options: { responsive:true, maintainAspectRatio:false }
                    });
                }
                const ctx2 = document.getElementById('usersChart')?.getContext('2d');
                if(ctx2){
                    new Chart(ctx2, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Fév', 'Mar', 'Avr'],
                            datasets: [{
                                label: 'Utilisateurs',
                                data: [200, 260, 300, 380],
                                fill: true,
                                backgroundColor: 'rgba(16,185,129,0.15)',
                                borderColor: 'rgb(16,185,129)'
                            }]
                        },
                        options: { responsive:true, maintainAspectRatio:false }
                    });
                }
            },
            setTab(t){
                this.tab = t;
                try { history.replaceState(null, '', '#'+t); } catch(e) {}
            }
        }
    }
</script>
@endsection
