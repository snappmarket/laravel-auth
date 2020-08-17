<?php

namespace SnappMarket\LaravelAuth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class SMGuard implements Guard
{
    use GuardHelpers;

    /**
     * @var UserProvider
     */
    private $provider;


    public function __construct(SMUserProvider $provider)
    {
        $this->provider = $provider;
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
        return $this->user;
    }
}