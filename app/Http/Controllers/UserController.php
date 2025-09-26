<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function update(Request $request, User $user)
    {
        // 1. Vérifier que l’utilisateur connecté peut modifier ce profil
        if ($user->id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        // 2. Validation des données
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 3. Gestion de la photo (si upload)
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // 4. Mise à jour
        $user->update($validated);

        // 5. Redirection avec message
        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }
}

