@props(['post', 'delay' => 0])

<div 
  class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-xl"
  data-aos="fade-up"
  data-aos-delay="{{ $delay }}"
>

  <h2 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h2>
  <p class="text-gray-700 mt-2">{{ $post->body }}</p>

  {{-- Médias --}}
  <div class="mt-4 space-y-4">
    @if ($post->media_type === 'multiple' && is_array($post->media_urls))
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($post->media_urls as $media)
          @if (Str::endsWith($media, ['.jpg', '.jpeg', '.png']))
            <img src="{{ $media }}" class="w-full rounded-lg transition-transform duration-300 hover:scale-105" alt="Image">
          @elseif (Str::endsWith($media, ['.mp4']))
            <video controls class="w-full rounded-lg">
              <source src="{{ $media }}" type="video/mp4">
            </video>
          @endif
        @endforeach
      </div>
    @else
      @if ($post->media_type === 'image')
        <img src="{{ $post->media_url }}" class="w-full mt-4 rounded-lg shadow transition-transform duration-300 hover:scale-105" alt="Image du post">
      @elseif ($post->media_type === 'video')
        <video controls class="w-full mt-4 rounded-lg shadow">
          <source src="{{ $post->media_url }}" type="video/mp4">
        </video>
      @endif
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
