<?php

namespace SnappMarket\LaravelAuth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use SnappMarket\Auth\Communicator;

class SMGuard implements Guard
{
    use GuardHelpers;

    /**
     * @var Communicator
     */
    private $communicator;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;


    public function __construct(SMUserProvider $provider, Communicator $communicator, Request $request)
    {
        $this->provider     = $provider;
        $this->communicator = $communicator;
        $this->request      = $request;
    }

    public function validate(array $credentials = [])
    {
        return (bool) $this->attempt($credentials);
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function attempt(array $credentials)
    {
        return $this->login($credentials);
    }

    private function login(array $credentials)
    {
        $user = $this->provider->retrieveByCredentials($credentials);
        $this->setUser($user);

        return $user->getToken();
    }

    public function user()
    {
        if ($this->user === null && $this->request->bearerToken()) {
            $this->user = $this->provider->retrieveByToken(null, $this->request->bearerToken());
        }

        return $this->user;
    }



    public function refresh()
    {
        return $this->communicator->refresh($this->request->bearerToken());
    }



    public function logout()
    {
        $this->communicator->logout($this->user()->getToken());
    }
}
