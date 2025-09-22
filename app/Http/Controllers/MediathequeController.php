<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediathequeController extends Controller
{
    /**
     * Liste filtrée des médias
     */
    public function create()
    {
        return view('medias.create_Media');
    }

    public function index(Request $request)
    {
        $category = $request->query('category');
        $implantation = $request->query('implantation');
        $month = $request->query('month');

        $query = Media::active()->orderBy('date_publication','desc');

        if ($category === 'photo') {
            $query->whereIn('category', ['photo', 'video']);
        } elseif ($category) {
            $query->where('category', $category);
        }
        if ($implantation) $query->where('implantation', $implantation);
        if ($month) {
            $query->whereRaw("DATE_FORMAT(date_publication, '%Y-%m') = ?", [$month]);
        }

        // On récupère tout, puis on filtre les doublons côté PHP
        $allMedias = $query->get();

        // Filtrer pour ne garder que le plus récent par (nom, media_url)
        $uniqueMedias = $allMedias->unique(function($item) {
            return $item->nom . '|' . $item->media_url;
        })->values();

        // Paginer manuellement
        $perPage = 12;
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $pagedMedias = new \Illuminate\Pagination\LengthAwarePaginator(
            $uniqueMedias->forPage($currentPage, $perPage),
            $uniqueMedias->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Filtres
        $implantations = Media::select('implantation')->distinct()->pluck('implantation')->filter()->values();
        $months = Media::selectRaw("DATE_FORMAT(date_publication, '%Y-%m') as month")
            ->distinct()->orderBy('month','desc')->pluck('month')->filter()->values();

        return view('mediatheque', [
            'medias' => $pagedMedias,
            'implantations' => $implantations,
            'months' => $months
        ]);
    }

    /**
     * Upload d’un nouveau média
     */

    public function store(Request $request)
    {
        $request->validate([
            'media_url'       => 'required',
            'media_url.*'     => 'file|max:51200|mimes:jpeg,png,jpg,gif,mp4,pdf',
            'category'        => 'required|in:photo,video,rapport',
            'nom'             => 'nullable|string|max:255',
            'implantation'    => 'nullable|string|max:100',
            'date_publication'=> 'nullable|date',
            'date_expiration' => 'nullable|date|after:date_publication',
        ]);

        foreach ($request->file('media_url') as $file) {
            $path = $file->store('medias','public');
            $media_url = Storage::url($path);

            // Empêcher l'ajout d'un média déjà existant (même nom ET même url)
            if (Media::where('nom', $request->nom ?? $file->getClientOriginalName())
                    ->where('media_url', $media_url)
                    ->exists()) {
                continue; // Ignore ce fichier et passe au suivant
                // OU pour bloquer tout l'upload :
                // return back()->withErrors('Ce média existe déjà.');
            }

            Media::create([
                'nom'             => $request->nom ?? $file->getClientOriginalName(),
                'category'        => $request->category,
                'implantation'    => $request->implantation,
                'media_url'       => $media_url,
                'media_type'      => $file->getMimeType(),
                'date_publication'=> $request->date_publication ?? now(),
                'date_expiration' => $request->date_expiration ?? now()->addDays(80),
                'archived'        => false,
            ]);
        }

        return redirect()
            ->route('admin.medias.index')
            ->with('media_success', 'Média ajouté avec succès !')
            ->with('tab', 'medias');
    }

    /**
     * Prolonger la visibilité
     */
    public function extend(Media $media)
    {
        $media->update([
            'date_expiration' => $media->date_expiration?->addDays(30) ?? now()->addDays(30)
        ]);

        return back()->with('success','Visibilité prolongée de 30 jours.');
    }

    /**
     * Supprimer un média
     */
    public function destroy(Media $media)
    {
        // Supprimer le fichier du storage
        if ($media->media_url && Storage::disk('public')->exists(str_replace('/storage/','',$media->media_url))) {
            Storage::disk('public')->delete(str_replace('/storage/','',$media->media_url));
        }

        $media->delete();

        return back()->with('success','Média supprimé.');
    }
}
