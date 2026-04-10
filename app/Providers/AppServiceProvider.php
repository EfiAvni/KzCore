<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('currentTenant', function () {
            try {
                if (! Schema::hasTable('tenants')) {
                    return null;
                }

                $host = request()->getHost();

                $tenant = Tenant::query()
                    ->where('domain', $host)
                    ->orWhereHas('domains', fn ($query) => $query->where('domain', $host))
                    ->first();

                if ($tenant) {
                    return $tenant;
                }

                if (in_array($host, ['localhost', '127.0.0.1'], true)) {
                    return Tenant::query()->orderBy('id')->first();
                }
            } catch (\Throwable $e) {
                return null;
            }

            return null;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::addLocation(base_path());

        try {
            if (Schema::hasTable('settings')) {
                View::composer('*', function ($view) {
                    $tenantId = app()->bound('currentTenant')
                        ? app('currentTenant')?->id
                        : null;

                    $tenantId ??= Auth::user()?->tenant_id;

                    $view->with('siteSettings', Setting::allForTenant($tenantId));
                });
            }
        } catch (\Exception $e) {
            // Ignore if db doesn't exist yet
        }
    }
}
