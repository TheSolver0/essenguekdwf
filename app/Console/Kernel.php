<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Définit le planning des commandes.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Exemple :
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Enregistre les commandes Artisan pour l'application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
