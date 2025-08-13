<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord
     */
    public function index()
    {
        // Récupère l'utilisateur connecté avec ses relations
        $user = Auth::user()->load([
            'campagnes', 
            'dons', 
            'userNotifications' // relation custom
        ]);

        // S'assurer que chaque relation est une collection
        $user->dons = $user->dons ?? collect();
        $user->campagnes = $user->campagnes ?? collect();
        $user->userNotifications = $user->userNotifications ?? collect();

        // Passe également les notifications séparément
        $notifications = $user->userNotifications;

        return view('dashboard', compact('user', 'notifications'));
    }


    /**
     * Mettre à jour le profil utilisateur
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validation des champs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Mise à jour des informations
        $user->name = $request->name;
        $user->email = $request->email;

        // Upload de la photo si présente
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}
