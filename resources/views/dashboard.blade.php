@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6 mt-20">

    <!-- 🔹 Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-blue-900">Mon Tableau de bord</h1>
        <button 
            class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600"
            onclick="document.getElementById('editModal').classList.remove('hidden')">
            ✏️ Modifier mon profil
        </button>
    </div>

    <!-- 🔹 Grille principale -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- ✅ Profil utilisateur -->
        <div class="text-center">
            <img src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('images/avatar.jpg') }}" 
                alt="Avatar"
                class="w-24 h-24 rounded-full mx-auto mb-3 border-4 border-blue-900">

            <!-- ✅ Badge juste sous la photo -->
            <div class="mb-2">
                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm shadow">
                    🎗️ {{ $user->badge ?? 'Standard' }}
                </span>
            </div>

            <h2 class="text-xl font-semibold text-blue-900">{{ $user->name }}</h2>
            <p class="text-gray-600">{{ $user->role ?? 'Donateur' }}</p>
        </div>


        <!-- ✅ Vue d'ensemble -->
        <div class="bg-white shadow-lg rounded-xl p-6 col-span-2">
            <h3 class="text-lg font-bold text-blue-900 mb-4">Vue d'ensemble</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg text-center">
                    <p class="text-2xl font-bold text-blue-900">
                        {{ number_format($user->total_dons ?? 0, 0, ',', ' ') }} FCFA
                    </p>
                    <p class="text-gray-600 text-sm">Total des dons</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg text-center">
                    <p class="text-2xl font-bold text-blue-900">
                        {{ optional($user->dons->last())->montant ?? 0 }} $
                    </p>
                    <p class="text-gray-600 text-sm">Campagnes soutenues</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg text-center">
                    <p class="text-2xl font-bold text-blue-900">
                        {{ optional($user->dons->last())->montant ?? 0 }} FCFA
                    </p>
                    <p class="text-gray-600 text-sm">Dernier don</p>
                </div>
            </div>
        </div>

        <!-- ✅ Historique des dons -->
        <div class="bg-white shadow-lg rounded-xl p-6 col-span-2">
            <h3 class="text-lg font-bold text-blue-900 mb-4">Historique des dons</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left">
                    <thead>
                        <tr class="bg-blue-100">
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Montant</th>
                            <th class="px-4 py-2">Campagne</th>
                            <th class="px-4 py-2">Méthode</th>
                            <th class="px-4 py-2">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(optional($user->dons) as $don)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $don->created_at->format('d/m/y') }}</td>
                                <td class="px-4 py-2">{{ number_format($don->montant,0,',',' ') }} FCFA</td>
                                <td class="px-4 py-2">{{ $don->campagne->titre ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $don->methode ?? 'N/A' }}</td>
                                <td class="px-4 py-2 text-green-600 font-semibold">{{ $don->statut ?? 'Confirmé' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-gray-500 text-center">
                                    Aucun don effectué pour l’instant.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ✅ Campagnes soutenues -->
        <div class="bg-white shadow-lg rounded-xl p-6 col-span-1">
            <h3 class="text-lg font-bold text-blue-900 mb-4">Campagnes soutenues</h3>
            <ul class="space-y-3">
                @forelse(optional($user->campagnes) as $campagne)
                    <li class="border p-3 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span>{{ $campagne->titre }}</span>
                            <span class="text-sm text-gray-500">{{ $campagne->statut ?? 'En cours' }}</span>
                        </div>
                        <div class="w-full bg-gray-200 h-2 rounded-full">
                            <div class="bg-blue-900 h-2 rounded-full" style="width: {{ $campagne->progression ?? 0 }}%"></div>
                        </div>
                    </li>
                @empty
                    <li class="text-gray-500">Aucune campagne soutenue pour l’instant.</li>
                @endforelse
            </ul>
        </div>

       <!-- ✅ Badges & Statut -->
        <div class="bg-white shadow-lg rounded-xl p-6 col-span-2">
            <h3 class="text-lg font-bold text-blue-900 mb-4">Badges & Statut</h3>

            <div class="flex gap-4 text-xl mb-4">
                @if($user->badge) <span>🎗️ {{ $user->badge }}</span> @endif
                @if($user->badge == 'Bienfaiteur') <span>🌿 Bienfaiteur</span> @endif
                @if($user->badge == 'Ambassadeur KDWF') <span>🏅 Ambassadeur KDWF</span> @endif
            </div>

            @php
                // ⚡ Exemple de paliers badges
                $levels = [
                    'Standard' => 0,
                    'Bienfaiteur' => 50000,
                    'Ambassadeur KDWF' => 200000,
                ];

                $total = $user->total_dons ?? 0;

                // Trouver le prochain palier
                $nextLevel = null;
                foreach($levels as $badgeName => $threshold){
                    if($total < $threshold){
                        $nextLevel = ['name' => $badgeName, 'threshold' => $threshold];
                        break;
                    }
                }

                if($nextLevel){
                    $previousThreshold = 0;
                    foreach($levels as $b => $t){
                        if($t < $nextLevel['threshold']){
                            $previousThreshold = $t;
                        }
                    }

                    $progress = (($total - $previousThreshold) / ($nextLevel['threshold'] - $previousThreshold)) * 100;
                    $progress = max(0, min(100, $progress));
                }
            @endphp

            @if($nextLevel)
                <p class="text-sm text-gray-600 mb-2">
                    Prochain badge : <span class="font-semibold">{{ $nextLevel['name'] }}</span>
                    (reste {{ number_format($nextLevel['threshold'] - $total, 0, ',', ' ') }} FCFA)
                </p>
                <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
                    <div class="bg-yellow-500 h-3 rounded-full" style="width: {{ $progress }}%"></div>
                </div>
            @else
                <p class="text-sm text-green-600 font-semibold">
                    🎉 Félicitations ! Vous avez atteint le badge maximum.
                </p>
            @endif
        </div>


        <!-- ✅ Notifications -->
        <div class="bg-white shadow-lg rounded-xl p-6 col-span-1">
            <h3 class="text-lg font-bold text-blue-900 mb-4">Notifications</h3>
            <ul class="space-y-3 text-sm">
                @forelse($notifications as $notification)
                    <li class="p-3 rounded-lg flex justify-between items-center 
                               {{ !$notification->is_read ? 'font-bold bg-yellow-50' : 'bg-gray-100 text-gray-600' }}">
                        <span>🔔 {{ $notification->title ?? 'Nouvelle notification' }} - {{ $notification->message }}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-400 text-xs">{{ $notification->created_at->diffForHumans() }}</span>
                            @if(!$notification->is_read)
                                <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-blue-600 text-xs">Marquer comme lu</button>
                                </form>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="text-gray-500">Aucune notification pour le moment.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- 🔹 Modal Modifier Profil -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <h2 class="text-xl font-bold text-blue-900 mb-4">Modifier mon profil</h2>

        <form method="POST" action="{{ route('user.update', Auth::user()) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nom -->
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium">Nom complet</label>
                <input type="text" name="name" class="w-full border rounded-lg px-3 py-2"
                       value="{{ old('name', Auth::user()->name) }}">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg px-3 py-2"
                       value="{{ old('email', Auth::user()->email) }}">
            </div>

            <!-- Photo -->
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium">Photo</label>
                <input type="file" name="photo" class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- Messages succès / erreurs -->
            @if(session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            @if($errors->any())
                <ul class="text-red-600 mb-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <!-- Boutons -->
            <div class="flex justify-end gap-2">
                <button type="button" 
                        class="px-4 py-2 bg-gray-200 rounded-lg"
                        onclick="document.getElementById('editModal').classList.add('hidden')">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-900 text-white rounded-lg">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
