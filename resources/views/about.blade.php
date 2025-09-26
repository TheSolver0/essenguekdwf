@extends('layouts.app')

@section('content')
<section class="relative h-[90vh] overflow-hidden">
    <img src="/images/logo-02.jpg" alt="logo" class="absolute inset-0 w-full h-full object-cover brightness-50 z-0">
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
        <h1 class="text-5xl md:text-7xl font-bold">QUI SOMMES-NOUS ?</h1>
    </div>
</section>

<section class="max-w-6xl mx-auto py-12 px-4 space-y-16">
    
    {{-- Mot du Président --}}
    <div class="grid md:grid-cols-3 gap-6 items-center">
        {{-- Images défilantes à gauche --}}
        <div class="relative overflow-hidden h-64 md:h-full scroll-container">
            <div class="absolute animate-scroll-down space-y-4">
                @foreach(range(1,10) as $i)
                    <img src="/images/img{{ $i }}.jpg" alt="Image {{ $i }}" class="w-full rounded-lg shadow-lg">
                @endforeach
            </div>
        </div>


        {{-- Texte --}}
        <div class="md:col-span-2 space-y-4 about-block">
            <h2 class="text-2xl font-bold underline">Mot du Président</h2>
            <p class="text-blue-500 font-semibold">Le Père King G. Joshua Love</p>
            <p>
            <b>La King’s Dream World Foundation</b>, a été pensée et créée pour contribuer modestement à la construction d’une société 
            meilleure permettant à chacun de connaître un réel épanouissement. Comment rester insensible face à la violation des droits  
            sociaux des veuves et des orphelins qui avec le temps, s’est érigé en pratiques tolérées et acceptées de tous ? Comment rester 
            indifférent face à la précarité des conditions de vie des veuves, des orphelins, des indigents, des enfants de la rue ?
            Notre principale mission est d’apporter du réconfort aux personnes nécessiteuses en général, et aux veuves et orphelins 
            en particulier. Notre vision est la contribution à l’édification d’une société équitable, plus juste, où tout le monde a 
            droit à l’éducation, peut décemment se nourrir, se vêtir et espérer à un avenir meilleur.

        </p>
        <p>
            Nombreux sont les orphelins, les nécessiteux, les veuves, les malades, les marginalisés qui ont bénéficié et bénéficient 
            encore de notre soutien. Bon nombre d’entre eux sont aujourd’hui autonomes, détenteurs d’activités génératrices de revenus. 
            Bon nombre de jeunes orphelins poursuivent aujourd’hui leurs études où ils réussissent brillamment. Les sollicitations 
            vis-à-vis de notre Fondation sont nombreuses. Nous sommes conscients de l’immensité de la tâche. Mais travaillant pour 
            les causes qui intéressent le Seigneur, car Il est le mari des veuves et le Père des orphelins, nous sommes certains qu’Il 
            pourvoira pour la continuité de notre action.
        </p>
        <p>
            Conscients de ce que Dieu Seul peut permettre un véritable changement de statut, nous prions qu’Il bénisse toutes les cibles 
            bénéficiaires de ce programme d’aide, d’appui et d’accompagnement dans une véritable réinsertion sociale et que leur 
            reconnaissance et gratitude à son endroit soi pour Sa Gloire et un témoignage de sa bonté.
        </p>
        </div>
    </div>

    {{-- Texte --}}
        <div class="md:col-span-2 space-y-4 about-block">
            <h2 class="text-2xl font-bold underline">Objet de la fondation</h2>
            <p class="text-blue-500 font-semibold">la raison d'etre</p>
            <p>
                <b>La King’s Dream World Foundation</b>, La King’s Dream World Foundation est une association apolitique et à but non 
                lucratif qui a pour objet de promouvoir et de protéger les personnes vulnérables, indigentes ou en difficulté notamment, 
                les orphelins, les veuves, les enfants de la rue, les prostitués, les grands malades, les personnes abandonnées et 
                les jeunes désœuvrés.
            </p>

            <p>
                L’association est en cours de création de structures d’encadrement social et de formation professionnelle pour lui 
                permettre d’atteindre ses objectifs.
            </p>
            </div>
        </div>

    {{-- Nos Objectifs --}}
    <div class="grid md:grid-cols-3 gap-6 items-center">
        {{-- Texte --}}
        <div class="md:col-span-2 space-y-4 about-block">
            <h2 class="text-2xl font-bold underline">Nos Objectifs</h2>
            <p class="text-blue-500 font-semibold">Où allons nous ?</p>
            <ol class="list-decimal list-inside space-y-2">
                <li>Accueillir et écouter les personnes vulnérables pour un accompagnement psychosocial, matériel ou financier</li>
                <li>Réaliser les actions socio-caritatives en faveur des personnes vulnérables ou en difficulté</li>
                <li> Apporter un soutien à l’éducation ou à la formation professionnelle des personnes défavorisées ou désœuvrées</li>
                <li> Offrir un cadre d’accueil et de vie aux personnes vulnérables ou en difficultés</li>
                <li>  Créer des centres médico- sociaux en vue de soutenir et de développer les soins de santé primaires à moindre coût dans les zones démunies.</li>
            </ol>
        </div>

        {{-- Images défilantes à droite --}}
        <div class="relative overflow-hidden h-64 md:h-full">
            <div class="absolute animate-scroll-up space-y-4">
                @foreach(range(6,10) as $i)
                    <img src="/images/img{{ $i }}.jpg" alt="Image {{ $i }}" class="w-full rounded-lg shadow-lg">
                @endforeach
            </div>
        </div>
    </div>

    {{-- Bouton retour --}}
    <div class="text-center">
        <a href="{{ route('home') }}" class="inline-block bg-blue-600 hover:bg-blue-800 text-white px-6 py-2 rounded-lg transition transform hover:scale-105">
            Retour à l'accueil
        </a>
    </div>
</section>

{{-- Script pour apparition gauche/droite --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const elements = document.querySelectorAll('.about-block');
        const items = Array.from(elements); // pour garder l'ordre du DOM

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const index = items.indexOf(entry.target); // vrai index dans le DOM
                    entry.target.classList.add(index % 2 === 0 ? 'animate-fade-left' : 'animate-fade-right');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        elements.forEach(el => observer.observe(el));
    });
</script>

@endsection
