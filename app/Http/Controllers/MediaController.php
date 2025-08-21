<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

/**
 * MediaController gère les opérations liées aux médias (images, vidéos) associés aux posts.
 */

class MediaController extends Controller
{
    public function destroy(Media $media)
    {
        // Supprimer le fichier du stockage
        if (Storage::disk('public')->exists(str_replace('/storage/', '', $media->media_url))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $media->media_url));
        }

        // Supprimer l'entrée en base
        $media->delete();

        return back()->with('success', 'Média supprimé avec succès.');
    }
}
