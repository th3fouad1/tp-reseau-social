<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repository\IUtilisateurRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\IInvitationRepository;
use App\Repository\InvitationRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Liaison de l'interface à son implémentation
        $this->app->bind(IUtilisateurRepository::class, UtilisateurRepository::class);
        $this->app->bind(IInvitationRepository::class, InvitationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
