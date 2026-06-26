<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureSuperAdminGate();
        $this->configureDefaults();

        try {
            view()->share('settings', \App\Models\Setting::pluck('value', 'key')->toArray());
        } catch (\Exception $e) {
            // Silence database connection errors during migrations
        }
    }

    /**
     * Grant Super Admin users unrestricted access via Gate before-rule.
     */
    protected function configureSuperAdminGate(): void
    {
        \Illuminate\Support\Facades\Gate::before(function ($user, string $ability): ?bool {
            if ($user->hasRole('Super Admin')) {
                return true;
            }

            return null;
        });

        \Illuminate\Support\Facades\Gate::define('manage-roles', fn ($user): bool => $user->hasRole('Super Admin'));
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
