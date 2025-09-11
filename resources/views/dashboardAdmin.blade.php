@extends('layouts.app')

@section('content')
{{-- Empêche le flash des éléments x-show au chargement --}}
<style>[x-cloak]{ display:none !important; }</style>

<div x-data="dashboard()" x-init="init()" class="min-h-screen bg-gray-50">
    {{-- Layout avec header déjà présent dans app.blade.php (probablement fixed). On laisse un padding-top. --}}
    <div class="pt-20">
        <div class="flex">
            {{-- Sidebar FIXE sous le header --}}
            <aside class="fixed top-20 bottom-0 left-0 w-64 bg-blue-600 text-white flex-shrink-0 mt-28">
                <div class="p-6 text-2xl font-bold">KDWF</div>
                <nav class="h-[calc(100%-6rem)] overflow-y-auto px-2 pb-6">
                    <ul class="space-y-1">
                        <template x-for="menu in menus" :key="menu.tab">
                            <li>
                                <a href="#" @click.prevent="setTab(menu.tab)"
                                   class="flex items-center px-4 py-2 rounded transition"
                                   :class="tab === menu.tab ? 'bg-blue-500/80' : 'hover:bg-blue-500/40'">
                                    <span x-text="menu.name"></span>
                                </a>
                            </li>
                        </template>
                    </ul>
                </nav>
            </aside>

            {{-- Zone de contenu scrollable indépendamment --}}
            <main class="ml-64 w-[calc(100%-16rem)] min-h-[calc(100vh-5rem)]">
                <div class="relative h-[calc(100vh-5rem)] overflow-hidden"> {{-- Contrainte, chaque panneau gère son scroll --}}

                    {{-- ================= Accueil ================= --}}
                    <section x-show="tab === 'accueil'" x-cloak
                             class="absolute inset-0 overflow-y-auto px-6 md:px-10 pb-10"
                             x-transition:enter="transition duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">

                        {{-- Header --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Dashboard — Accueil</h1>
                            <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Créer un post</a>
                        </div>

                        {{-- Cartes statistiques --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                            <div class="bg-white p-6 rounded-2xl shadow">
                                <a href="{{ route('admin.users.index') }}" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-300 block">
                                    <h2 class="text-sm font-semibold text-gray-500">Total utilisateurs</h2>
                                    <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $totalUsers }}</p>
                                </a>
                            </div>
                            <div class="bg-white p-6 rounded-2xl shadow">
                                <h2 class="text-sm font-semibold text-gray-500">Dons reçus</h2>
                                <p class="mt-2 text-3xl font-bold text-sky-600">{{ $totalDonations ?? '5 482 €' }}</p>
                            </div>
                            <div class="bg-white p-6 rounded-2xl shadow">
                                <h2 class="text-sm font-semibold text-gray-500">Nouveaux messages</h2>
                                <p class="mt-2 text-3xl font-bold text-rose-600">{{ $newMessages ?? 23 }}</p>
                            </div>
                            <div class="bg-white p-6 rounded-2xl shadow">
                                <h2 class="text-sm font-semibold text-gray-500">Activités récentes</h2>
                                <p class="mt-2 text-3xl font-bold text-gray-700">{{ $recentActivities ?? 21 }}</p>
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
                                                    <td class="px-4 py-2 font-medium">{{ $post->title }}</td>
                                                    <td class="px-4 py-2 text-gray-600">{{ $post->created_at->format('d/m/Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="2" class="px-4 py-6 text-center text-gray-500">Aucun post</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Notifications (exemple) --}}
                            <div class="bg-white p-6 rounded-2xl shadow">
                                <h3 class="text-lg font-semibold mb-4">Notifications récentes</h3>
                                <ul class="space-y-3">
                                    @forelse(($notifications ?? []) as $n)
                                        <li class="flex items-start gap-3">
                                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                                            <div>
                                                <p class="text-sm">{{ $n->title ?? 'Notification' }}</p>
                                                <p class="text-xs text-gray-500">{{ $n->created_at?->diffForHumans() }}</p>
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
                             class="absolute inset-0 overflow-y-auto px-6 md:px-10 pb-10"
                             x-transition:enter="transition duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                        <div class="flex items-center justify-between mb-6">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Activités / Posts</h1>
                            <a href="{{ route('posts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">Créer un post</a>
                        </div>

                        <div class="border rounded-2xl shadow overflow-hidden">
                            <div class="max-h-[60vh] overflow-y-auto">
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
                                                    <button @click="openEdit=true" class="px-3 py-1 bg-lime-600 text-white rounded hover:bg-lime-700">Modifier</button>
                                                    <button @click="openDelete=true" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
                                                </div>

                                                {{-- Modal Edit Post --}}
                                                <div x-show="openEdit" x-cloak x-transition
                                                     class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 p-4">
                                                    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative">
                                                        <h2 class="text-xl font-semibold mb-4">Modifier le post</h2>
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

                                                            <div class="flex justify-end gap-2">
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
                             class="absolute inset-0 overflow-y-auto px-6 md:px-10 pb-10"
                             x-transition:enter="transition duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                        <div class="flex items-center justify-between mb-6">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Événements</h1>
                            <a href="{{ route('events.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">Créer un événement</a>
                        </div>

                        <div class="border rounded-2xl shadow overflow-hidden">
                            <div class="max-h-[60vh] overflow-y-auto">
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
                                                    <button @click="openEdit=true" class="px-3 py-1 bg-lime-600 text-white rounded hover:bg-lime-700">Modifier</button>
                                                    <button @click="openDelete=true" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
                                                </div>

                                                {{-- Modal Edit Event --}}
                                                <div x-show="openEdit" x-cloak x-transition
                                                     class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 p-4">
                                                    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative">
                                                        <h2 class="text-xl font-semibold mb-4">Modifier l’événement</h2>
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
                                                            <div class="mt-6 flex justify-end gap-2">
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

                </div>
            </main>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    function dashboard(){
        return {
            tab: 'accueil',
            menus: [
                { name:'Accueil / Vue générale', tab:'accueil' },
                { name:'Activités / Posts', tab:'posts' },
                // Campagnes supprimé comme demandé
                { name:'Événements', tab:'evenements' },
                { name:'Dons & Finances', tab:'dons', disabled:true },
                { name:'Utilisateurs', tab:'utilisateurs', disabled:true },
                { name:'Modération', tab:'moderation', disabled:true },
                { name:'Implantations', tab:'implantations', disabled:true },
                { name:'Medias', tab:'medias', disabled:true },
                { name:'Newsletter', tab:'newsletter', disabled:true },
                { name:'Statistiques', tab:'statistiques', disabled:true },
                { name:'Contact / Messages', tab:'contact', disabled:true },
                { name:'Badges / Ambassadeurs', tab:'badges', disabled:true },
                { name:'Notifications', tab:'notifications', disabled:true },
            ],
            init(){
                // Tab depuis l'ancre si présente
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
