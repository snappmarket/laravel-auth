<?php

namespace SnappMarket\LaravelAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SnappMarket\LaravelAuth\Gate;

class Authorize
{

    /**
     * @var Gate
     */
    private $gate;

    public function __construct(Gate $gate)
    {

        $this->gate = $gate;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function handle($request, Closure $next, $ability)
    {
        $this->gate->authorize($ability, ['token' => $request->get('token')]);

        return $next($request);
    }
}