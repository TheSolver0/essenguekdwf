@props(['post', 'delay' => 0])

<div class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-xl" data-aos="fade-up"
    data-aos-delay="{{ $delay }}">

    <h2 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h2>
    <p class="text-gray-700 mt-2">{{ $post->body }}</p>

    {{-- Médias --}}
    <div class="mt-4 space-y-4">
    @if ($post->media->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($post->media as $media)
                @php
                    $isImage = Str::endsWith($media->media_url, ['.jpg', '.jpeg', '.png', '.webp']);
                    $isVideo = Str::endsWith($media->media_url, ['.mp4', '.mov', '.avi']);
                @endphp

                <div class="relative group rounded-lg overflow-hidden shadow hover:scale-105 transition-transform duration-300">
                    @if ($isImage)
                        <img src="{{ $media->media_url }}" alt="Image"
                             class="w-full h-auto object-cover cursor-pointer"
                             onclick="openLightbox('{{ $media->media_url }}')">
                    @elseif ($isVideo)
                        <div class="relative">
                            <video controls class="w-full h-auto rounded-lg">
                                <source src="{{ $media->media_url }}" type="video/mp4">
                                Votre navigateur ne supporte pas la lecture vidéo.
                            </video>
                        </div>
                    @endif

                    <!-- Bouton de suppression -->
                    <form action="{{ route('media.destroy', $media->id) }}" method="POST"
                          class="absolute top-2 right-2 hidden group-hover:block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 text-white px-2 py-1 rounded text-sm hover:bg-red-700 transition">
                            Supprimer
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Aucun média associé à ce post.</p>
    @endif
</div>
    {{-- Like --}}
    <form action="{{ route('posts.like', $post->id) }}" method="POST" class="mt-6">
        @csrf
        <button
            class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition-all duration-200 shadow-sm">
            ❤️ J'aime ({{ $post->likes->count() }})
        </button>
    </form>

    {{-- Commentaires --}}
    <div class="mt-6">
        <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="space-y-2">
            @csrf
            <textarea name="content" rows="2"
                class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-lime-500 focus:outline-none transition"
                placeholder="Ajouter un commentaire..."></textarea>
            <button type="submit"
                class="bg-lime-500 text-white px-4 py-2 rounded hover:bg-lime-600 transition">Commenter</button>
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
