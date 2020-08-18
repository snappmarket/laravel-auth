<?php


use Illuminate\Http\Request;
use SnappMarket\LaravelAuth\Gate;

class authorize
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
     * @param  Request  $request
     * @param Closure $next
     *
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $ability)
    {
        $this->gate->authorize($ability, ['token' => $request->get('token')]);

        return $next($request);
    }
}