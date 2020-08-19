<?php


namespace SnappMarket\LaravelAuth;


use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use SnappMarket\Auth\Communicator;

class SMAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerAuthenticator();
        $this->registerUserResolver();
        $this->registerAccessGate();
    }

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

    /**
     * Register the authenticator services.
     *
     * @return void
     */
    protected function registerAuthenticator()
    {
        $this->app->singleton('auth', function ($app) {
            // Once the authentication service has actually been requested by the developer
            // we will set a variable in the application indicating such. This helps us
            // know that we need to set any queued cookies in the after event later.
            $app['auth.loaded'] = true;

            return new AuthManager($app);
        });

        $this->app->singleton('auth.driver', function ($app) {
            return $app['auth']->guard();
        });
    }

    /**
     * Register a resolver for the authenticated user.
     *
     * @return void
     */
    protected function registerUserResolver()
    {
        $this->app->bind(
            AuthenticatableContract::class, function ($app) {
            return call_user_func($app['auth']->userResolver());
        });
    }

    /**
     * Register the access gate service.
     *
     * @return void
     */
    protected function registerAccessGate()
    {
        $this->app->singleton(GateContract::class, function ($app) {
            return new SMGate($this->app->make(Communicator::class), $app, function () use ($app) {
                return call_user_func($app['auth']->userResolver());
            });
        });
    }
}
