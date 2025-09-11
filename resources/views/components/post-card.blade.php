@props(['post', 'delay' => 0, 'id' => null])

<div 
  id="{{ $id }}"
  class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-xl"
  data-aos="fade-up"
  data-aos-delay="{{ $delay }}"
>
  {{-- Titre + date --}}
  <h2 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h2>
  <p class="text-gray-500 text-sm mb-2">
      Publié {{ $post->created_at->diffForHumans() }}
  </p>

  {{-- Description --}}
  <p class="text-gray-700 mt-2 whitespace-pre-line">{{ $post->body }}</p>


  {{-- Médias --}}
    @if ($post->media->count())
      <div class="mt-4 grid gap-2 
          @if($post->media->count() === 1) grid-cols-1
          @elseif($post->media->count() === 2) grid-cols-2
          @elseif($post->media->count() === 3) grid-cols-3
          @else grid-cols-2 md:grid-cols-3
          @endif
      ">
        @foreach ($post->media as $index => $media)
          <div 
            class="relative w-full aspect-[16/9] overflow-hidden rounded-lg cursor-pointer group"
            onclick="openLightbox({{ $post->id }}, {{ $index }})"
          >
            @if ($media->media_type === 'image')
              <img src="{{ $media->media_url }}" 
                  class="w-full h-full object-cover group-hover:opacity-90 transition" 
                  alt="{{ $post->title }} - image {{ $loop->iteration }}">
            @elseif ($media->media_type === 'video')
              <video class="w-full h-full object-cover" muted>
                <source src="{{ $media->media_url }}" type="video/mp4">
              </video>
              <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z"/>
                </svg>
              </div>
            @endif
          </div>
        @endforeach
      </div>
    @endif


  {{-- Actions --}}
  <div class="flex items-center justify-between mt-5 text-gray-600">

    {{-- Like --}}
    <div 
      @guest onclick="window.location.href='{{ route('login') }}'" @else
        x-data="{ liked: {{ $post->likedBy(auth()->user()) ? 'true' : 'false' }} === 'true', count: {{ $post->likes->count() }} }"
      @endguest
    >
      <button 
        @auth
          @click.prevent="
            liked = !liked;
            count += liked ? 1 : -1;

            fetch('{{ route('posts.like', $post->id) }}', {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
              },
              body: ''
            });
          "
        @endauth
        class="flex items-center gap-1 group"
      >
        <svg xmlns="http://www.w3.org/2000/svg" 
          :fill="liked ? 'red' : 'none'" 
          viewBox="0 0 24 24" stroke="currentColor"
          class="w-6 h-6"
          :class="liked ? 'text-red-500' : 'text-gray-400 group-hover:text-red-500'">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
              2 6 4 4 6.5 4c1.74 0 3.41 1.01 4.13 2.44h.74C14.09 5.01 
              15.76 4 17.5 4 20 4 22 6 22 8.5c0 3.78-3.4 6.86-8.55 
              11.54L12 21.35z"/>
        </svg>
        <span>
          @auth
            <span x-text="count"></span>
          @else
            {{ $post->likes->count() }}
          @endauth
        </span>
      </button>
    </div>

    {{-- Commenter --}}
    <div x-data="{ openComment: false }" class="relative">
        <button @click="openComment = !openComment" class="flex items-center gap-1 hover:text-lime-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 10h8M8 14h6m-6 6h.01M21 12c0 4.418-3.582 8-8 8H7l-4 4V12c0-4.418 
                      3.582-8 8-8s8 3.582 8 8z" />
            </svg>
            <span>{{ $post->comments->count() }}</span>
        </button>

        {{-- Formulaire dynamique --}}
        <div x-show="openComment" x-cloak x-transition.opacity
            class="absolute left-0 mt-2 w-[300px] md:w-[400px] bg-white border border-gray-300 rounded p-4 shadow-lg z-50">
            @auth
                <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="space-y-2">
                    @csrf
                    <textarea name="content" rows="2" 
                              class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-lime-500 focus:outline-none transition" 
                              placeholder="Ajouter un commentaire..."></textarea>
                    <button type="submit" class="w-full bg-lime-500 text-white px-4 py-2 rounded hover:bg-lime-600 transition">Commenter</button>
                </form>
            @else
                <button onclick="window.location.href='{{ route('login') }}'" 
                        class="w-full bg-lime-500 text-white px-4 py-2 rounded hover:bg-lime-600 transition">
                    Se connecter pour commenter
                </button>
            @endauth
        </div>
    </div>

    {{-- Partager --}}
    <button onclick="navigator.share({ title: '{{ $post->title }}', url: '{{ url('/posts/'.$post->id) }}' })" 
      class="flex items-center gap-1 hover:text-blue-600">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 12v.01M12 4v.01M20 12v.01M12 20v.01M12 4a8 8 0 00-8 8h2a6 6 0 0112 0h2a8 8 0 00-8-8z"/>
      </svg>
      <span>Partager</span>
    </button>
  </div>

  {{-- Liste des commentaires --}}
  <ul class="mt-4 space-y-2">
      @php
          $commentsToShow = $post->comments->take(-3); // Les 3 derniers commentaires
          $remainingComments = $post->comments->count() - $commentsToShow->count();
      @endphp

      @foreach ($commentsToShow as $comment)
        <li class="text-sm text-gray-600 border-l-4 border-lime-500 pl-3 bg-gray-50 p-2 rounded">
          {{ $comment->content }}
        </li>
      @endforeach
  </ul>

  {{-- Bouton Voir plus si plus de 3 commentaires --}}
  @if($post->comments->count() > 3)
      <div x-data="{ showAll: false }" class="mt-2">
          <ul x-show="showAll" x-cloak class="space-y-2">
              @foreach ($post->comments->slice(0, -3) as $comment)
                  <li class="text-sm text-gray-600 border-l-4 border-lime-500 pl-3 bg-gray-50 p-2 rounded">
                      {{ $comment->content }}
                  </li>
              @endforeach
          </ul>
          <button @click="showAll = !showAll" 
                  class="text-sm text-lime-500 hover:underline mt-1">
              <span x-text="showAll ? 'Voir moins' : 'Voir plus'"></span>
          </button>
      </div>
  @endif

</div>
