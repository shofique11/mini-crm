<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Lead;
use App\Policies\LeadPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Lead::class => LeadPolicy::class, // Register Lead Policy properly
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies(); // This automatically registers the policies

        // Define a gate for lead creation
        Gate::define('create-lead', [LeadPolicy::class, 'create']);
    }
}
