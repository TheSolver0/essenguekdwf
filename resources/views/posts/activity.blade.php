@extends('layouts.app')

@section('content')
<div class="pt-[140px] md:pt-[160px] max-w-3xl mx-auto space-y-10 px-4">
  @foreach ($posts as $index => $post)
    <x-post-card :post="$post" :delay="$index * 100" id="post-{{ $post->id }}" />
  @endforeach
</div>



{{-- Lightbox globale --}}
<div id="lightbox" class="hidden fixed inset-0 bg-black/90 z-[60] flex items-center justify-center">
    {{-- Bouton fermeture --}}
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white text-3xl z-70">&times;</button>

    <div class="relative w-full max-w-4xl flex items-center justify-center">
        {{-- Précédent --}}
        <button onclick="prevMedia()" class="absolute left-4 text-white text-4xl z-70">&#10094;</button>
        
        {{-- Contenu --}}
        <div id="lightbox-content" class="w-full max-h-[80vh] flex items-center justify-center"></div>
        
        {{-- Suivant --}}
        <button onclick="nextMedia()" class="absolute right-4 text-white text-4xl z-70">&#10095;</button>
    </div>
</div>

<script>
let currentPostId = null;
let currentIndex = 0;
let postsMedia = @json(
    $posts->mapWithKeys(fn($p) => [$p->id => $p->media->map(fn($m) => [
        'url' => $m->media_url,
        'type' => $m->media_type
    ])])
);

function openLightbox(postId, index) {
    currentPostId = postId;
    currentIndex = index;
    showMedia();
    document.getElementById('lightbox').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.getElementById('lightbox-content').innerHTML = '';
    document.body.style.overflow = '';
}

function showMedia() {
    if(!postsMedia[currentPostId] || !postsMedia[currentPostId][currentIndex]) return;
    let media = postsMedia[currentPostId][currentIndex];
    let content = '';
    if (media.type === 'image') {
        content = `<img src="${media.url}" class="max-h-[80vh] object-contain">`;
    } else if (media.type === 'video') {
        content = `<video src="${media.url}" controls autoplay muted class="max-h-[80vh]"></video>`;
    }
    document.getElementById('lightbox-content').innerHTML = content;
}

function nextMedia() {
    if (currentIndex < postsMedia[currentPostId].length - 1) {
        currentIndex++;
        showMedia();
    } else {
        closeLightbox();
    }
}

function prevMedia() {
    if (currentIndex > 0) {
        currentIndex--;
        showMedia();
    }
}

document.addEventListener('keydown', function(e) {
    if(e.key === "Escape") closeLightbox();
});

document.getElementById('lightbox').addEventListener('touchmove', function() {
    closeLightbox();
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if(window.location.hash) {
        const el = document.querySelector(window.location.hash);
        if(el) {
            el.classList.add("highlighted");
            setTimeout(() => el.classList.remove("highlighted"), 3000);
        }
    }
});
</script>

