<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Définir les commandes planifiées.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Archiver automatiquement les médias expirés chaque jour
        $schedule->call(function () {
            \App\Models\Media::where('archived', false)
                ->whereNotNull('date_expiration')
                ->whereDate('date_expiration', '<', now())
                ->update(['archived' => true]);
        })->daily();
    }

    /**
     * Enregistrer les commandes artisan.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
