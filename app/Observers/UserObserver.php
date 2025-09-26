<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Événement déclenché à chaque mise à jour d'un utilisateur
     */
    public function updateBadge()
    {
        $badge = $this->badge;

        if ($this->total_likes > 0 || $this->total_commentaires > 0) {
            $badge = 'Membre';
        }

        if ($this->total_dons < 10 && $this->total_dons > 0) {
            $badge = 'Nouveau Donateur';
        }

        if ($this->total_dons >= 500) {
            $badge = 'Bienfaiteur';
        }

        if ($this->total_dons >= 1000 && $this->total_likes > 0 && $this->total_commentaires > 0) {
            $badge = 'Ambassadeur KDWF';
        }

        if ($badge !== $this->badge) {
            $this->badge = $badge;
            $this->saveQuietly(); // évite de déclencher updated()
        }
    }


    /**
     * Événement déclenché à la création d'un utilisateur
     */
    public function created(User $user)
    {
        // Initialise le badge
        $user->updateBadge();
    }
}
