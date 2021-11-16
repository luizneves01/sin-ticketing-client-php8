<?php
namespace Hillus\SinTicketingClient;

use Exception;
use Hillus\SinTicketingClient\Rest\SinApi;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @throws \Exception
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__.'/../config/sinticketing.php';
        $this->mergeConfigFrom($configPath, 'sinticketing');

       
        // $this->app->alias('sinticketing', SinApi::class);

        $this->app->singleton('sinticketing', function ($app) {
            return new SinApi($app['config'], $app['files']);
        });

    }

    /**
     * Check if package is running under Lumen app
     *
     * @return bool
     */
    protected function isLumen()
    {
        return Str::contains($this->app->version(), 'Lumen') === true;
    }

    public function boot()
    {
        if (! $this->isLumen()) {
            $configPath = __DIR__.'/../config/sinticketing.php';
            $this->publishes([$configPath => config_path('sinticketing.php')], 'config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('sinticketing');
    }

}
