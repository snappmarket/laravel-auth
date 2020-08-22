<?php

namespace SnappMarket\LaravelAuth\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Http\Request;

class CanAll
{

    /**
     * @var GateContract
     */
    private $gate;

    public function __construct(GateContract $gate)
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
    public function handle($request, Closure $next, $ability,...$constraints)
    {
        $this->gate->check($this->parsPermissions($ability), [
             'token'       => $request->bearerToken(),
             'constraints' => $this->parseConstraints($constraints),
        ]);

        return $next($request);
    }



    protected function parsPermissions(string $permissions): array
    {
        return explode('|', $permissions);
    }



    protected function parseConstraints(array $constraints)
    {
        $results = [];

        foreach ($constraints as $constraint) {
            [$key, $value] = explode('|', $constraint);
            $results[$key] = $value;
        }

        return $results;
    }
}
