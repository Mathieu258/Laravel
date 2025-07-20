<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Stand;
use App\Models\Produit;
use App\Models\Commande;
use App\Policies\StandPolicy;
use App\Policies\ProduitPolicy;
use App\Policies\CommandePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Stand::class => StandPolicy::class,
        Produit::class => ProduitPolicy::class,
        Commande::class => CommandePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
} 