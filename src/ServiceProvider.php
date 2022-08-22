<?php

namespace JustBetter\MagentoWebhooks;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use JustBetter\MagentoWebhooks\Actions\DispatchEvents;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this
            ->registerConfig()
            ->registerActions();
    }

    protected function registerConfig(): static
    {
        $this->mergeConfigFrom(__DIR__.'/../config/magento-webhooks.php', 'magento-webhooks');

        return $this;
    }

    protected function registerActions(): static
    {
        DispatchEvents::bind();

        return $this;
    }

    public function boot(): void
    {
        $this
            ->bootConfig()
            ->bootRoutes();
    }

    protected function bootConfig(): static
    {
        $this->publishes([
            __DIR__.'/../config/magento-webhooks.php' => config_path('magento-webhooks.php'),
        ], 'config');

        return $this;
    }

    protected function bootRoutes(): static
    {
        if (! $this->app->routesAreCached()) {
            Route::prefix(config('magento-webhooks.prefix'))
                ->middleware(config('magento-webhooks.middleware'))
                ->group(fn () => $this->loadRoutesFrom(__DIR__.'/../routes/api.php'));
        }

        return $this;
    }
}
