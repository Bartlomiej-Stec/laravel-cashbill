<?php
namespace Barstec\Cashbill;

use Illuminate\Support\ServiceProvider;

final class CashbillServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'cashbill');
    }

    private function getRoutesPath(): string
    {
        return realpath(__DIR__ . '/../routes/api.php');
    }

    private function getConfigPath(): string
    {
        return realpath(__DIR__ . '/../config/cashbill.php');
    }

    private function loadRoutes(): void
    {
        if (config('cashbill.route_enabled', true)) {
            $path = $this->getRoutesPath();
            $this->loadRoutesFrom($path);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            $this->getConfigPath() => config_path('cashbill.php'),
        ], 'config');
        $this->loadRoutes();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
