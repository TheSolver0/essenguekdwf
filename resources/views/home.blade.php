@extends('layouts.app')

@section('content')

@php
// Exemple de données si tu n'envoies pas depuis le controller
$projects = $projects ?? [
    ['id'=>1,'name'=>'Centre d’Accueil de la Petite Enfance (CAPE-KDWF)','total'=>50000,'collected'=>25000,'image'=>'project1.jpg'],
    ['id'=>2,'name'=>'Centre d’Accueil de la Personne Agée Abandonnée et Handicapée (CAPAH-KDWF)','total'=>80000,'collected'=>45000,'image'=>'project2.jpg'],
];

// Exemple dons simples
    $simpleDonations = $simpleDonations ?? 25000; 

    // Total collecté = somme des collectés de tous les projets + dons simples
    $totalCollected = array_sum(array_column($projects, 'collected')) + $simpleDonations;

$testimonials = $testimonials ?? [
    ['name'=>'Savio', 'photo'=>'testi1.jpg', 'content'=>"Je m’appelle Savio, j’ai 22 ans. Il y a encore quelques années, j’étais complètement perdu. J’ai dû abandonner l’école à l’âge de 15 ans. Ma famille, frappée par la pauvreté, ne pouvait plus subvenir à mes besoins. Très vite, j’ai dû chercher des petits boulots pour survivre. Je passais mes journées à vendre de l’eau ou à transporter des marchandises au marché. Pendant ce temps, mes rêves s’effondraient, et je pensais que c’était la fin de mon avenir   Mais un jour, ma vie a changé. J’ai été mis en contact avec la King Dream World Foundation. Ils m’ont écouté sans me juger, ils ont cru en moi alors que je ne croyais plus en moi-même. Grâce à leur soutien, j’ai pu retourner à l’école. Ils ont pris en charge mes frais de scolarité, mes fournitures, et m’ont offert un accompagnement psychologique et éducatif   Aujourd’hui, je suis diplômé en informatique, je travaille dans une start-up locale et je forme à mon tour d’autres jeunes dans mon quartier. Je suis devenu indépendant, responsable, et surtout utile à ma communauté. Sans la KDWF, je serais sûrement encore dans la rue, sans espoir. Grâce à eux, j’ai retrouvé ma dignité, mes rêves et une direction dans ma vie. Je suis la preuve vivante que lorsqu’on tend la main à un jeune en détresse, on peut réveiller un futur plein de promesses. Merci à la King Dream World Foundation, du fond du cœur"],
    ['name'=>'James', 'photo'=>'testi2.jpg', 'content'=>"Je m’appelle James, et depuis mon plus jeune âge, j’ai toujours été un élève brillant. J’aimais apprendre, je comprenais vite, et mes résultats scolaires étaient excellents. Mais malgré tout cela, un obstacle immense se dressait devant moi : le manque de moyens financiers. Mes parents n’avaient pas les ressources nécessaires pour payer mes frais de scolarité, encore moins pour me permettre de poursuivre des études supérieures. C’était douloureux de voir mon potentiel étouffé simplement à cause d’une réalité économique. À plusieurs reprises, j’ai failli tout laisser tomber, non pas par manque de volonté, mais par manque d’opportunités.

C’est alors que mon chemin a croisé celui de la King Dream World Foundation. Cette rencontre a tout changé. Ils ont vu en moi plus qu’un jeune sans moyens ; ils ont vu un avenir, une promesse. Grâce à leur soutien financier et moral, j’ai pu reprendre mes études, aller plus loin, et multiplier les diplômes. Aujourd’hui, je suis titulaire de plusieurs diplômes universitaires dans des domaines qui me passionnent. Je travaille dans un secteur dynamique, je gagne bien ma vie, et je suis pleinement épanoui professionnellement.

Je n’ai jamais cessé d’être brillant, mais la KDWF m’a donné la chance d’exprimer cette intelligence, de la transformer en compétences et en impact réel. Sans eux, tout cela serait resté un rêve. Aujourd’hui, je suis la preuve qu’il suffit parfois d’un coup de pouce, d’une main tendue, pour que la lumière en nous puisse briller pleinement. Merci à la King Dream World Foundation de m’avoir permis de prendre mon envol."],
    ['name'=>'Joseph', 'photo'=>'testi3.jpg', 'content'=>"Je m’appelle Joseph. Mon parcours scolaire a été long et semé d’embûches. J’ai passé le baccalauréat sept fois. Chaque échec était une blessure profonde, une remise en question douloureuse. À un moment donné, j’ai voulu tout abandonner. Ma mère, malgré tout son amour et ses efforts, n’avait plus les moyens de m’aider à continuer. J’étais au bord du découragement total, sans issue, sans perspective. Mais c’est dans ce moment de grande détresse que ma vie a basculé. J’ai fait la rencontre d’un homme qui, depuis, est devenu un père pour moi : le président de la King Dream World Foundation. Ce n’était pas une rencontre ordinaire. C’était une intervention divine, une réponse de Dieu. Car oui, cet homme est un oint de l’Éternel, conduit par une inspiration qui dépasse l’humain.

Il a cru en moi alors que je ne croyais plus en moi-même. Il m’a dit avec assurance : « Tu vas retourner à l’école, et cette fois, tu vas réussir. » Et grâce à la King Dream World Foundation, tous mes frais scolaires ont été pris en charge. Soutenu, encouragé et entouré, j’ai repris les études avec foi et détermination, et j’ai obtenu mon bac cette même année-là. Par la suite, j’ai découvert une passion profonde pour l’audiovisuel. La fondation m’a encore accompagné, et j’ai pu me former, progresser, jusqu’à devenir aujourd’hui un expert reconnu dans le domaine. J’ai eu la grâce de travailler avec des structures importantes comme Vox Africa, et de participer à des projets médiatiques qui impactent.

Mais au-delà de la réussite professionnelle, Dieu avait encore plus pour moi. Aujourd’hui, je suis également pasteur. J’annonce la Parole, j’encourage les jeunes à garder la foi, et je témoigne de ce que Dieu peut faire lorsqu’on ne baisse pas les bras. Je suis la preuve vivante qu’un jeune brisé, abandonné, peut devenir un instrument puissant entre les mains de Dieu, lorsque des personnes choisissent de tendre la main. Merci à la King Dream World Foundation, merci à mon père spirituel, le président. Grâce à vous, ma vie a pris un tout autre sens, et aujourd’hui, c’est à mon tour de faire une différence."],
    ['name'=>'Marie Victoire', 'photo'=>'testi4.jpg', 'content'=>"Je m’appelle Marie Victoire, et si je devais résumer mon parcours en un mot, ce serait grâce. Il fut un temps où l’école était pour moi un rêve suspendu. Les circonstances de la vie, les difficultés financières, et l'absence d'appui concret avaient interrompu mon parcours scolaire. J'avais soif d’apprendre, de grandir, de m’accomplir, mais je n’en avais tout simplement pas les moyens. C’est dans cette saison d’attente, entre frustration et espoir, que la King Dream World Foundation est intervenue. Elle n’a pas seulement financé mon retour à l’école, elle a cru en moi, en mon potentiel, et m’a accompagnée dans tout mon processus d’insertion socio-professionnelle.

Grâce à cette fondation, j’ai pu reprendre mes études, les poursuivre avec excellence, et aujourd’hui, j’ai un background académique solide allant jusqu’au doctorat. Mais ce n’est pas tout. Par la grâce de Dieu, je travaille, je suis autonome, et je m’épanouis dans ma vie professionnelle. En parallèle, j’ai découvert et accepté mon appel : je suis aujourd’hui chantre, et je voyage à travers le monde pour répandre le message de l’Évangile à travers la musique. Ce que je vis aujourd’hui dépasse ce que j’aurais pu imaginer. Ce que j’ai accompli n’est pas uniquement le fruit de mes efforts, c’est le résultat d’une intervention divine — Dieu a agi au travers de la King Dream World Foundation.

Je suis reconnaissante pour cette œuvre, pour ceux qui y servent avec cœur, et surtout pour l’homme de Dieu à la tête de cette fondation, un instrument puissant entre les mains du Seigneur. Sans cette fondation, beaucoup de portes seraient restées fermées. Aujourd’hui, je chante, je sers, je travaille, je voyage — et tout cela, c’est Dieu qui l’a rendu possible à travers eux. Je suis Marie Victoire, et ma vie est un témoignage vivant de ce que Dieu peut faire lorsqu’on décide de croire en une destinée."],
    ['name'=>'Clara', 'photo'=>'testi5.jpg', 'content'=>"Grâce à eux j'ai pu... témoignage complet 5."],
];


    $images = [
        [
            'src' => 'images/insertion.jpeg',
            'desc' => 'Favoriser l’accès à l’éducation, à la formation et à l’insertion socio-professionnelle',
            'details' => 'Soutenir la scolarisation, organiser des formations professionnelles et créer des activités génératrices de revenus pour permettre aux bénéficiaires de devenir autonomes et de s’intégrer pleinement dans la société.'
        ],
        [
            'src' => 'images/i2.jpg',
            'desc' => 'Promouvoir la santé et le bien-être dans les communautés défavorisées',
            'details' => 'Mettre en place des structures médico-sociales, fournir des soins de santé primaires à moindre coût, et mener des actions préventives et curatives pour améliorer la santé physique et mentale des bénéficiaires.'
        ],
        [
            'src' => 'images/reconfor.jpg',
            'desc' => 'Apporter assistance et réconfort aux personnes vulnérables',
            'details' => 'Offrir un soutien social, matériel, financier et psychologique aux veuves, orphelins, enfants de la rue, indigents, malades, personnes âgées, handicapées et autres personnes en difficulté, afin d’améliorer leurs conditions de vie et favoriser leur dignité.'
        ],
    ];

@endphp

{{-- ==== COVER / Valeurs (conserve ton script machine à écrire si utile) ==== --}}
<section class="relative h-[480px] flex flex-col items-center justify-center text-white bg-cover bg-center"
    style="background-image: url('{{ asset('images/f2.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <div class="relative z-10 text-center max-w-3xl px-4">
        <h1 id="typed-text" class="text-4xl md:text-5xl font-bold mb-4"></h1>
        <p id="typed-description" class="text-lg md:text-xl opacity-0 transition-opacity duration-500"></p>

        <div class="mt-6 flex flex-wrap gap-4 justify-center">
            <a href="{{ route('media') }}" class="px-4 py-2 bg-lime-500 hover:bg-lime-600 text-black font-semibold rounded">
                Découvrir nos actions
            </a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">
                Participer Maintenant
            </a>
        </div>
    </div>
</section>

{{-- Petit style personnalisé pour les titres et modal --}}
<style>
    /* header section style (bar bleu + bande rose à gauche) */
    .section-header { display:flex; align-items:center; gap:12px; margin-bottom:1rem; }
    .section-header .pink { width:10px; height:34px; background:#ff4dab; border-radius:3px; }
    .section-header .blue-bar { background:#0ea5e9; color:#fff; padding:8px 14px; border-radius:2px; font-weight:600; }

    /* Modal */
    #testimonial-modal { opacity:0; pointer-events:none; transition: opacity .25s ease; }
    #testimonial-modal.open { opacity:1; pointer-events:auto; }
    #testimonial-modal .modal-panel { transform: translateY(16px) scale(.99); transition: transform .25s ease; }
    #testimonial-modal.open .modal-panel { transform: translateY(0) scale(1); }

    /* Ombre plus prononcée comme sur maquette */
    .card-deep-shadow { box-shadow: 0 10px 18px rgba(0,0,0,0.12), 0 6px 8px rgba(0,0,0,0.06); }
</style>

{{-- Section Notre Vision --}}
    <section class="bg-white py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="section-header">
            <div class="pink"></div>
            <div class="blue-bar">Notre Vision</div>
        </div>
            <div class="flex flex-col md:flex-row items-center gap-8">
                {{-- Vidéo autoplay --}}
                <video autoplay muted loop class="w-full md:w-1/2 rounded shadow-lg">
                    <source src="{{ asset('videos/vid.mp4') }}" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>

                {{-- Texte vision --}}
                <p class="text-gray-700 md:w-1/2">
                    Dans sa volonté manifeste d’apporter une solution et un soulagement 
                    social et matériel aux nombreuses personnes vulnérables, indigentes 
                    ou en difficulté, <b>la King’s Dream World Foundation </b> a vu le jour. 
                    Depuis sa création en 2002, cette fondation porte un regard nouveau vers 
                    les cibles qui bénéficient d’une attention particulière pour leur 
                    épanouissement et leur développement.            
                </p>
            </div>
        </div>
    </section>

{{-- ==== Événements à venir ==== --}}
<section class="bg-green-50 py-10 px-4">
  <div class="max-w-6xl mx-auto">
      <div class="section-header mb-6">
          <div class="pink"></div>
          <div class="blue-bar">Événements à venir</div>
      </div>

      @foreach($events as $event)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">

            {{-- Image / Vidéo principale --}}
            @if($event->media->count() > 0)
                @php $firstMedia = $event->media->first(); @endphp

                @if($firstMedia->media_type === 'image')
                    <img src="{{ asset('storage/'.$firstMedia->media_url) }}"
                         alt="media de {{ $event->title }}"
                         class="w-full h-auto object-contain">
                @elseif($firstMedia->media_type === 'video')
                    <video src="{{ asset('storage/'.$firstMedia->media_url) }}"
                           class="w-full h-64 object-cover"
                           autoplay muted loop></video>
                @endif
            @else
                {{-- Fallback si aucun média --}}
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500">
                    Aucun média disponible
                </div>
            @endif
            <div data-countdown="{{ $event->start_date }}" 
                class="mt-4 flex justify-center">
                <span class="countdown 
                            px-4 py-2 
                            bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 
                            text-white font-bold text-lg rounded-lg shadow-lg animate-pulse 
                            tracking-wider">
                    ⏳ Chargement...
                </span>
            </div>
            {{-- Infos événement --}}
            <div class="p-4">
              <h3 class="text-xl font-bold mb-2">
                  {{ $event->title }} - {{ $event->location }}
              </h3>
              <p class="mb-2 text-gray-600 whitespace-pre-line">{{ $event->description }}</p>
              <div class="text-center">
                    <p class="bg-sky-600 text-sm text-white">Début : {{ $event->start_date }}</p>

                    <a href="{{ route('don.event',$event->id) }}" 
                        class="mt-3 inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 ">
                        Soutenir l’événement
                    </a>
              </div>
            </div>
        </div>
      @endforeach
  </div>
</section>


{{-- ==== Actualité ==== --}}
<section class="bg-white py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="section-header">
            <div class="pink"></div>
            <div class="blue-bar">Actualité</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @isset($latestPosts)
                @foreach($latestPosts as $post)
                    <a href="{{ route('activity') }}#post-{{ $post->id }}" 
                    class="bg-white rounded-lg overflow-hidden card-deep-shadow transform transition hover:shadow-lg block">

                        <div class="relative group overflow-hidden">
                           @php
                                $mediaUrl = $post->media->first()->media_url ?? null;
                            @endphp

                            @if($mediaUrl)
                                <img src="{{ $mediaUrl }}" 
                                    alt="{{ $post->title }}" 
                                    class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <img src="{{ asset('images/default.jpg') }}" 
                                    alt="Image par défaut" 
                                    class="w-full h-48 object-cover">
                            @endif

                            {{-- Overlay au hover --}}
                            <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 
                                        flex items-center justify-center text-white text-center p-4 
                                        transition-opacity duration-300">
                                <p class="text-sm">{{ Str::limit($post->excerpt ?? $post->content, 100) }}</p>
                            </div>
                        </div>

                        {{-- Contenu du post --}}
                        <div class="p-4">
                            <h3 class="text-lg font-bold mb-2">{{ $post->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                {{ Str::limit($post->excerpt ?? $post->content, 80) }}
                            </p>
                        </div>
                    </a>
                @endforeach
            @endisset
        </div>

        <div class="p-4">
            <h3 class="text-lg font-bold mb-2">Pour voir plus </h3>
            <p class="text-gray-600 text-sm mb-4">concernant l'actualite cliquer sur le boutton ci-dessous</p>
            <a href="{{ route('activity') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-semibold text-sm">
                Voir l’actualité
            </a>
        </div>
    </div>
</section>


{{-- ==== Nos Missions Régaliènnes ==== --}}
<section class="bg-green-50 py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="section-header">
            <div class="pink"></div>
            <div class="blue-bar">Nos Mission Regalienne</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($images as $image)
            <div class="bg-white rounded-lg overflow-hidden card-deep-shadow transform transition">
                <!-- Image container -->
                <div class="relative group cursor-pointer overflow-hidden card-container">
                    <img src="{{ asset($image['src']) }}" 
                        alt="Image"
                        class="w-full h-48 object-cover transition-transform duration-500">

                    <!-- Texte descriptif -->
                    <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center text-white text-center p-4 opacity-0 transition-opacity duration-500 description-text">
                        <p>{{ $image['desc'] }}</p>
                    </div>

                    <!-- Bandeau défilant -->
                    <div class="absolute bottom-0 w-full bg-gray-800 text-white text-sm p-2 overflow-hidden">
                        <marquee behavior="scroll" direction="left">{{ $image['details'] }}</marquee>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</section>

<style>
.image-card.active img {
    transform: translateY(-2.5rem); /* Décalage vers le haut */
    transition: transform 0.5s ease;
}
.image-card.active div.absolute {
    opacity: 1; /* Affiche le texte */
}
.image-card div.absolute {
    opacity: 0; /* Cache le texte par défaut */
    transition: opacity 0.5s ease;
}
</style>


{{-- ==== Projets Phares (avec montants dynamiques) ==== --}}
<section class="bg-white py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="section-header">
            <div class="pink"></div>
            <div class="blue-bar">Projets Phares</div>
        </div>

        <div class="space-y-6">
            @foreach($projects as $proj)
                <div class="bg-white rounded-lg card-deep-shadow overflow-hidden md:flex">
                    {{-- Photo --}}
                    <div class="bg-pink-500 flex items-center justify-center text-black font-bold w-full md:w-1/3 h-48 md:h-auto">
                        <!--span class="text-3xl">Photo</!--span-->
                        <img 
                            src="{{ asset('images/' . $proj['image']) }}" 
                            alt="{{ $proj['name'] }}" 
                            class="w-full h-full object-cover"
                        >
                    </div>

                    {{-- Details --}}
                    <div class="p-6 flex-1">
                        <h3 class="text-xl font-bold mb-2">{{ $proj['name'] }}</h3>
                        <p class="mb-2">
                            <span class="font-semibold">Coût total :</span>
                            <span class="project-total" data-value="{{ $proj['total'] }}">0</span> $
                        </p>

                        <div class="mb-4">
                            <div class="flex items-center gap-4 text-sm mb-2">
                                <div>Coût collecté : <span class="project-collected text-pink-600" data-value="{{ $proj['collected'] }}">0</span> $</div>
                                <div>Coût restant : <span class="project-remaining text-blue-600" data-value="{{ max(0, $proj['total'] - $proj['collected']) }}">0</span> $</div>
                            </div>

                            {{-- Progress bar --}}
                            <div class="w-full bg-gray-200 h-4 rounded-full overflow-hidden">
                                <div class="project-progress h-4 rounded-full" style="width:0%; background: linear-gradient(90deg,#34d399,#06b6d4)"></div>
                            </div>
                        </div>

                        <p class="text-gray-600 text-sm">
                            descriptopn
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==== Témoignages (carrousel) ==== --}}
<section class="bg-green-50 py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-center text-3xl font-bold mb-6">TÉMOIGNAGE</h2>

        <div class="relative">
            {{-- piste du carrousel --}}
            <div class="overflow-hidden">
                <div id="testimonial-track" class="flex transition-transform duration-500">
                    @foreach($testimonials as $t)
                        <div class="testimonial-slide min-w-full sm:min-w-[50%] md:min-w-[33.333%] lg:min-w-[40%] px-3">
                            <div class="bg-white rounded-lg p-6 card-deep-shadow cursor-pointer h-full flex flex-col items-center"
                                data-name="{{ $t['name'] }}"
                                data-photo="{{ asset('images/'.$t['photo']) }}"
                                data-text="{{ $t['content'] }}">
                                <div class="w-24 h-24 rounded-full border-2 border-green-500 flex items-center justify-center text-lg font-bold mb-4 bg-white overflow-hidden">
                                    <img src="{{ asset('images/'.$t['photo']) }}" alt="{{ $t['name'] }}" class="w-full h-full object-cover">
                                </div>
                                <h3 class="text-lg font-semibold">{{ $t['name'] }}</h3>
                                <p class="text-gray-600 text-center mt-2 line-clamp-3">
                                    {{ Str::limit($t['content'], 120) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- flèches --}}
            <button id="prev-btn" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2">
                &#10094;
            </button>
            <button id="next-btn" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2">
                &#10095;
            </button>
        </div>

        <!--p class="text-center mt-3 text-sm text-gray-700">En carrousel de {{ count($testimonials) }}</!--p-->
    </div>
</section>

{{-- ==== Modal Témoignage ==== --}}
<div id="testimonial-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4">
    <div class="modal-panel bg-white rounded-lg max-w-2xl w-full p-6">
        <div class="flex justify-end">
            <button id="modal-close" class="text-gray-600 hover:text-gray-900 text-xl">&times;</button>
        </div>
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-green-500 flex-shrink-0">
                <img id="modal-photo" src="" alt="photo" class="w-full h-full object-cover">
            </div>
            <div>
                <h3 id="modal-name" class="text-2xl font-bold mb-2"></h3>
                <p id="modal-text" class="text-gray-700"></p>
            </div>
        </div>
    </div>
</div>


{{-- ==== Section impact ==== --}}
<div style="background-color:#009fe3; color:white; text-align:center; padding:20px;">
    <h2>Votre Impact</h2>
    <h1 id="impact-amount" style="font-size:50px; margin:0;">0$</h1>
    <p>collectés grâce à votre générosité.</p>
</div>

<!-- Animation JS de l'impact -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    let amountElement = document.getElementById("impact-amount");
    let start = 0;
    let end = {{ $totalCollected }}; // Valeur dynamique envoyée depuis PHP
    let duration = 2000; // Durée de l'animation (2 sec)
    let increment = Math.ceil(end / (duration / 20)); // Calcul de l'incrément

    let timer = setInterval(function() {
        start += increment;
        if (start >= end) {
            start = end;
            clearInterval(timer);
        }
        amountElement.textContent = start.toLocaleString() + "$";
    }, 20);
});
</script>

{{-- ==== SCRIPTS: typed text, carousel, modal, animate projects ==== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    /* ===== typed text (Cover) - simple machine à écrire ===== */
    (function(){
        const values = [
            { title: "LA VIE", description: "Mettre la personne au centre de ses actions en favorisant sa dignité, son autonomie, sa responsabilité et en lui donnant les moyens d’être acteur de sa vie." },
            { title: "LE SOCIAL", description: "Privilégier le lien social en préservant et construisant des relations autour de la personne dans la famille, le quartier, avec les professionnels ou les associations." },
            { title: "LE RESPECT", description: "Respecter strictement les volontés des donateurs." },
            { title: "LA LOYAUTÉ", description: "Garantir la rigueur et la transparence dans ses pratiques." }
        ];
        const titleEl = document.getElementById("typed-text");
        const descEl = document.getElementById("typed-description");
        let idx = 0;
        if (titleEl && descEl) {
            function typeEffect(text, cb) {
                let i=0;
                titleEl.textContent = "";
                function tick(){
                    if(i <= text.length){
                        titleEl.textContent = text.substring(0,i);
                        i++;
                        setTimeout(tick, 60);
                    } else cb && cb();
                }
                tick();
            }
            function showNext(){
                const cur = values[idx];
                descEl.classList.remove('opacity-100'); descEl.classList.add('opacity-0');
                typeEffect(cur.title, () => {
                    descEl.textContent = cur.description;
                    descEl.classList.remove('opacity-0'); descEl.classList.add('opacity-100');
                    setTimeout(() => {
                        idx = (idx+1) % values.length;
                        setTimeout(showNext, 600);
                    }, 3800);
                });
            }
            showNext();
        }
    })();

    /* ===== Projets - animation montants & progress bar ===== */
    (function animateProjects(){
        function animateValue(el, start, end, duration, formatter) {
            const range = end - start;
            const startTime = performance.now();
            function step(now) {
                const progress = Math.min((now - startTime)/duration, 1);
                const value = Math.floor(start + range * progress);
                el.textContent = formatter ? formatter(value) : value;
                if (progress < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }

        document.querySelectorAll('.project-total').forEach(function(totalEl, idx){
            const card = totalEl.closest('.card-deep-shadow') || totalEl.closest('div');
            const collectedEl = card.querySelector('.project-collected');
            const remainingEl = card.querySelector('.project-remaining');
            const progressEl = card.querySelector('.project-progress');

            const total = parseInt(totalEl.dataset.value) || 0;
            const collected = parseInt(collectedEl.dataset.value) || 0;
            const remaining = Math.max(0, total - collected);
            const percent = total > 0 ? Math.round((collected/total)*100) : 0;

            const fmt = (n) => new Intl.NumberFormat('fr-FR').format(n);

            // animate counters
            animateValue(totalEl, 0, total, 900, (v) => fmt(v));
            animateValue(collectedEl, 0, collected, 900, (v) => fmt(v));
            animateValue(remainingEl, 0, remaining, 900, (v) => fmt(v));

            // animate progress bar
            setTimeout(()=> {
                if(progressEl) {
                    progressEl.style.width = percent + '%';
                }
            }, 300);
        });
    })();

/* ===== Témoignage - carrousel & modal ===== */
(function () {
    const track = document.getElementById('testimonial-track');
    const slides = Array.from(track.querySelectorAll('.testimonial-slide'));
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');

    let index = 0;
    let visible = computeVisible();

    // Scroll pour texte court dans les slides
    slides.forEach(slide => {
        const textContainer = slide.querySelector('.testimonial-text');
        if (textContainer) {
            textContainer.style.maxHeight = "200px";
            textContainer.style.overflowY = "auto";
            textContainer.style.paddingRight = "5px";
        }
    });

    // Nombre de slides visibles en fonction de la taille de l'écran
    function computeVisible() {
        const w = window.innerWidth;
        if (w >= 640) return 2; // toujours 2 à partir de tablette
        return 1;               // mobile
    }

    // Mise à jour de la taille des slides
    function updateSizes() {
        visible = computeVisible();
        slides.forEach(slide => {
            slide.style.minWidth = (100 / visible) + '%';
        });

        const maxIndex = Math.max(0, slides.length - visible);
        if (index > maxIndex) index = maxIndex;
        moveTo(index);
    }

    // Déplacement du carrousel
    function moveTo(i) {
        const translatePercent = (i * (100 / visible));
        track.style.transform = `translateX(-${translatePercent}%)`;
    }

    // Navigation précédente
    prevBtn.addEventListener('click', function () {
        index = Math.max(0, index - 1);
        moveTo(index);
    });

    // Navigation suivante
    nextBtn.addEventListener('click', function () {
        const maxIndex = Math.max(0, slides.length - visible);
        if (slides.length > visible) {
            index = (index + 1) % (maxIndex + 1); // boucle
        }
        moveTo(index);
    });

    // Adaptation au redimensionnement
    window.addEventListener('resize', updateSizes);
    updateSizes();

    // MODAL
    const modal = document.getElementById('testimonial-modal');
    const modalPhoto = document.getElementById('modal-photo');
    const modalName = document.getElementById('modal-name');
    const modalText = document.getElementById('modal-text');
    const modalClose = document.getElementById('modal-close');

    function openModal(name, photo, text) {
        modalPhoto.src = photo;
        modalName.textContent = name;
        modalText.textContent = text;

        // Appliquer le scroll si le texte est long
        modalText.style.maxHeight = "60vh";       // max hauteur
        modalText.style.overflowY = "auto";       // scroll vertical
        modalText.style.paddingRight = "8px";     // marge pour scrollbar

        modal.classList.add('open');
    }

    function closeModal() {
        modal.classList.remove('open');
    }

    // Clic sur une slide => ouvrir modal
    slides.forEach(slide => {
        slide.addEventListener('click', function () {
            const cardEl = slide.querySelector('[data-name]') || slide;
            const name = cardEl.dataset.name || '';
            const photo = cardEl.dataset.photo || '';
            const text = cardEl.dataset.text || '';
            openModal(name, photo, text);
        });
    });

    // Fermer modal au clic sur le bouton ou arrière-plan
    modalClose.addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    // Fermer modal avec touche "Échap"
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });
})();


});
</script>

<script>
    //js des mission
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.image-card').forEach(card => {
        card.addEventListener('click', () => {
            card.classList.toggle('active');
        });
    });
});
</script>
<script>
document.querySelectorAll('.card-container').forEach(card => {
    const desc = card.querySelector('.description-text');
    let isVisible = false;

    card.addEventListener('click', () => {
        isVisible = !isVisible;
        desc.style.opacity = isVisible ? '1' : '0';
    });
});
</script>

<script>
    //compte a rebout
document.addEventListener("DOMContentLoaded", function () {
    const countdowns = document.querySelectorAll("[data-countdown]");

    countdowns.forEach(el => {
        const targetDate = new Date(el.getAttribute("data-countdown")).getTime();
        const span = el.querySelector(".countdown");

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance <= 0) {
                span.textContent = "Événement en cours ou terminé";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            span.textContent = `${days}j ${hours}h ${minutes}m ${seconds}s`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
});
</script>


@endsection
