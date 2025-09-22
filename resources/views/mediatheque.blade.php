@extends('layouts.app')

@section('content')
<style>
  .media-card {
    transition: transform .3s cubic-bezier(.4,2,.6,1), box-shadow .3s;
  }
  .media-card:hover {
    transform: translateY(-8px) scale(1.03) rotate(-1deg);
    box-shadow: 0 8px 32px 0 rgba(0,0,0,0.18);
    z-index: 2;
  }
  .media-btn {
    transition: box-shadow .2s, transform .2s;
  }
  .media-btn:hover {
    box-shadow: 0 4px 16px 0 rgba(0,0,0,0.18);
    transform: scale(1.05);
  }
  .wm-overlay{
    pointer-events:none;
    position:absolute; inset:0;
    display:flex; align-items:center; justify-content:center;
    opacity:0.08; font-size:40px; transform:rotate(-20deg);
    color:#000; mix-blend-mode: multiply;
  }
  .pdf-frame { pointer-events: none; }

  @keyframes cyclic {
  0% { letter-spacing: 0; color: #0369a1;}
  50% { letter-spacing: 4px; color: #22d3ee;}
  100% { letter-spacing: 0; color: #0369a1;}
}
.animate-cyclic { animation: cyclic 2.5s infinite; }

@keyframes orbit { 0%{transform:rotate(0deg) translateX(60px);} 100%{transform:rotate(360deg) translateX(60px);} }
@keyframes orbit2 { 0%{transform:rotate(0deg) translateX(-60px);} 100%{transform:rotate(360deg) translateX(-60px);} }
@keyframes orbit3 { 0%{transform:rotate(0deg) translateY(-40px);} 100%{transform:rotate(360deg) translateY(-40px);} }
.animate-orbit { animation: orbit 3s linear infinite; }
.animate-orbit2 { animation: orbit2 4s linear infinite; }
.animate-orbit3 { animation: orbit3 5s linear infinite; }
</style>

<div class="min-h-screen flex items-center justify-center pt-20 pb-10 bg-gradient-to-br from-blue-50 to-lime-50">
  <div class="w-full max-w-5xl px-4">

    <!-- Intro centré -->
    <div class="text-center mb-10">
      <div class="relative flex justify-center items-center mb-4">
          <h1 class="text-4xl md:text-5xl font-bold text-sky-800 drop-shadow animate-cyclic">
              BIENVENUE DANS LA MÉDIATHÈQUE DE LA KDWF
          </h1>
          <span class="absolute left-0 top-1/2 -translate-y-1/2 animate-orbit text-yellow-400 text-3xl">★</span>
          <span class="absolute right-0 top-1/2 -translate-y-1/2 animate-orbit2 text-blue-400 text-2xl">●</span>
          <span class="absolute left-1/2 top-0 -translate-x-1/2 animate-orbit3 text-lime-400 text-2xl">◆</span>
      </div>
      <p class="mt-4 text-gray-600 max-w-2xl mx-auto text-lg">
        Choisissez ce que vous souhaitez consulter : photos & vidéos ou rapports d'activité.<br>
        Les contenus sont publiés par implantation et organisés par mois.
      </p>
      <!-- Deux grands boutons -->
      <div class="mt-8 flex items-center justify-center gap-8">
        <a href="{{ route('mediatheque', array_merge(request()->query(), ['category'=>'photo'])) }}"
           class="media-btn px-10 py-5 bg-blue-600 text-white rounded-xl text-2xl font-bold shadow-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition">
          <i class="fa fa-image mr-2"></i> Photos & Vidéos
        </a>
        <a href="{{ route('mediatheque', array_merge(request()->query(), ['category'=>'rapport'])) }}"
           class="media-btn px-10 py-5 bg-yellow-500 text-white rounded-xl text-2xl font-bold shadow-lg hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 transition">
          <i class="fa fa-file-alt mr-2"></i> Rapports d'activité
        </a>
      </div>
    </div>

    <!-- Filtres (implantation + mois) -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-8">
      <div class="flex gap-2 items-center">
        <label class="text-sm text-gray-600">Implantation :</label>
        <select onchange="location = updateQueryStringParameter(window.location.href,'implantation', this.value)" class="border rounded px-2 py-1" class="border-2 border-blue-400 rounded-lg px-3 py-2 bg-white shadow focus:ring-2 focus:ring-lime-400 transition>
          <option value="">Toutes</option>
          @foreach($implantations as $imp)
            <option value="{{ $imp }}" @if(request('implantation') == $imp) selected @endif>{{ $imp }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex gap-2 items-center">
        <label class="text-sm text-gray-600">Mois :</label>
        <select onchange="location = updateQueryStringParameter(window.location.href,'month', this.value)" class="border-2 border-blue-400 rounded-lg px-3 py-2 bg-white shadow focus:ring-2 focus:ring-lime-400 transition">
          <option value="">Tous</option>
          @foreach($months as $m)
            <option value="{{ $m }}" @if(request('month') == $m) selected @endif>{{ \Carbon\Carbon::createFromFormat('Y-m',$m)->translatedFormat('F Y') }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <!-- Grid médias -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @forelse($medias as $media)
        <div class="media-card relative bg-white rounded-2xl shadow overflow-hidden flex flex-col">
          <div class="wm-overlay">{{ $media->nom ?? $media->implantation ?? 'KDWF' }}</div>
          <button @click="openMedia('{{ $media->media_url }}', '{{ $media->category }}')" class="block w-full h-56 overflow-hidden rounded-xl focus:outline-none">
            @if($media->category === 'photo')
              <img src="{{ $media->media_url }}" alt="{{ $media->nom }}" class="w-full h-56 object-cover transition-all duration-300">
            @elseif($media->category === 'video')
              <video src="{{ $media->media_url }}" class="w-full h-56 object-cover transition-all duration-300" muted></video>
            @else
              <span class="block w-full h-56 flex items-center justify-center text-2xl text-gray-400">Rapport</span>
            @endif
          </button>
          <div class="p-4 flex-1 flex flex-col justify-between">
            <div>
              <div class="text-lg font-semibold text-gray-800">{{ $media->nom }}</div>
              <div class="text-xs text-gray-500 mt-1">{{ $media->implantation ?? 'Général' }} • {{ $media->date_publication->format('d/m/Y') }}</div>
            </div>
            <div class="text-xs text-gray-400 mt-2">{{ ucfirst($media->category) }}</div>
          </div>
        </div>
      @empty
        <div class="col-span-full text-center text-gray-500 p-8">Aucun média disponible.</div>
      @endforelse
    </div>

    <div class="mt-8">
      {{ $medias->links() }}
    </div>
  </div>
</div>

<div x-data="{ show:false, url:'', type:'' }" x-show="show" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50" x-cloak>
    <div class="bg-white rounded-xl shadow-lg p-4 relative max-w-2xl w-full">
        <button @click="show=false" class="absolute top-2 right-2 text-2xl text-gray-700 hover:text-red-500">&times;</button>
        <template x-if="type==='photo'">
            <img :src="url" class="w-full rounded-lg" />
        </template>
        <template x-if="type==='video'">
            <video :src="url" controls autoplay class="w-full rounded-lg"></video>
        </template>
        <template x-if="type==='rapport'">
            <iframe :src="url" class="w-full h-96 rounded-lg"></iframe>
        </template>
    </div>
</div>

<script>
    function openMedia(url, type) {
        document.querySelector('[x-data]').__x.$data.url = url;
        document.querySelector('[x-data]').__x.$data.type = type;
        document.querySelector('[x-data]').__x.$data.show = true;
    }
</script>

<!-- FontAwesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<script>
  function updateQueryStringParameter(uri, key, value) {
    let base = uri.split('?')[0];
    let query = new URLSearchParams(uri.split('?')[1] || '');
    if(!value) query.delete(key); else query.set(key, value);
    const q = query.toString();
    return base + (q ? ('?' + q) : '');
  }
  document.addEventListener('contextmenu', function(e){
    if(!document.body.classList.contains('allow-rightclick')) e.preventDefault();
  });
  document.addEventListener('selectstart', function(e){
    if(!document.body.classList.contains('allow-select')) e.preventDefault();
  });
</script>

<div 
    x-data="{ show:false, url:'', type:'' }" 
    x-show="show" 
    class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 p-4"
    x-cloak
    @keydown.escape.window="show=false"
>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-3xl mx-auto p-0 overflow-hidden flex flex-col items-center">
        <button @click="show=false" class="absolute top-3 right-3 text-3xl text-gray-700 hover:text-red-500 z-10">&times;</button>
        <template x-if="type==='photo'">
            <img :src="url" class="w-full max-h-[80vh] object-contain bg-black" />
        </template>
        <template x-if="type==='video'">
            <video :src="url" controls autoplay class="w-full max-h-[80vh] bg-black rounded-b-xl"></video>
        </template>
        <template x-if="type==='rapport'">
            <iframe :src="url" class="w-full h-[80vh] bg-gray-100"></iframe>
        </template>
    </div>
</div>
<script>
    function openMedia(url, type) {
        let modal = document.querySelector('[x-data]');
        modal.__x.$data.url = url;
        modal.__x.$data.type = type;
        modal.__x.$data.show = true;
    }
</script>
@endsection