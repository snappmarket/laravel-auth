<?php


namespace SnappMarket\LaravelAuth;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use SnappMarket\Auth\Communicator;

class SMAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('sm-user', function ($app, array $config) {
            return $app->make(SMUserProvider::class);
        });

        Auth::extend('sm-auth', function ($app, $name, array $config) {
            return new SMGuard($app->make(SMUserProvider::class));
        });

        $this->publishes([
            __DIR__ . '/../config/auth-communication.php' => config_path('auth-communication.php'),
        ], 'config');

        $this->app->bind(Communicator::class, function () {
            return new Communicator(
                $this->app['config']->get('auth-communication.baseUrl'),
                ['client' => $this->app['config']->get('auth-communication.client')],
                app('log')
            );
        });
    }
}
