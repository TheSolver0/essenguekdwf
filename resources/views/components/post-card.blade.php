@props(['post', 'delay' => 0, 'id' => null])

<div
  class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-xl"
  data-aos="fade-up"
  data-aos-delay="{{ $delay }}"
>

  <h2 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h2>
  <p class="text-gray-700 mt-2">{{ $post->body }}</p>

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
  </div>

  {{-- Like --}}
  <form action="{{ route('posts.like', $post->id) }}" method="POST" class="mt-6">
    @csrf
    <button class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition-all duration-200 shadow-sm">
      ❤️ J'aime ({{ $post->likes->count() }})
    </button>
  </form>

  {{-- Commentaires --}}
  <div class="mt-6">
    <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="space-y-2">
      @csrf
      <textarea name="content" rows="2" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-lime-500 focus:outline-none transition" placeholder="Ajouter un commentaire..."></textarea>
      <button type="submit" class="bg-lime-500 text-white px-4 py-2 rounded hover:bg-lime-600 transition">Commenter</button>
    </form>

    <ul class="mt-4 space-y-2">
      @foreach ($post->comments as $comment)
        <li class="text-sm text-gray-600 border-l-4 border-lime-500 pl-3 bg-gray-50 p-2 rounded">
          {{ $comment->content }}
        </li>
      @endforeach
    </ul>
  </div>
</div>
