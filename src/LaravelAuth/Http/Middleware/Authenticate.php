<?php


namespace SnappMarket\LaravelAuth\Http\Middleware;


use Closure;
use Illuminate\Contracts\Foundation\Application;
use SnappMarket\Auth\Exceptions\InvalidTokenException;

class Authenticate
{
    /**
     * @var Application
     */
    protected $app;



    /**
     * Authenticate constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }



    public function handle($request, Closure $next)
    {
        if ($request->user()) {
            return $next($request);
        }

        throw new InvalidTokenException;
    }
}
