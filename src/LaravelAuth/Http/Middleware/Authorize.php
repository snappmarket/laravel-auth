<?php

namespace SnappMarket\LaravelAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SnappMarket\LaravelAuth\SMGate;

class Authorize
{

    /**
     * @var SMGate
     */
    private $gate;

    public function __construct(SMGate $gate)
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
     * @param $ability
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function handle($request, Closure $next, $ability)
    {
        $this->gate->authorize($ability, ['token' => $request->get('token')]);

        return $next($request);
    }
}