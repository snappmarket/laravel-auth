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

    /**
     * retrieve Identifier on api gateway
     *
     * @var int|null
     */
    protected $gatewayIdentifier;

    /**
     * retrieve Identifier Secret Token on api gateway
     *
     * @var string|null
     */
    protected $gatewayIdentifierSecret;

    /**
     * retrieve Identifier Secret Token on configuration
     *
     * @var string|null
     */
    protected $configGatewaySecretKey;

    public function __construct(SMUserProvider $provider, Communicator $communicator, Request $request)
    {
        $this->provider      = $provider;
        $this->communicator  = $communicator;
        $this->request       = $request;
        $this->gatewayIdentifier = $request->header(config('auth-communication.gateway.parameters.identifier'), null);
        $this->gatewayIdentifierSecret = $request->header(config('auth-communication.gateway.parameters.key'), null);
        $this->configGatewaySecretKey = config('auth-communication.gateway.secret_key', null);
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
        if ($this->user) {
            return $this->user;
        }

        switch (true) {
            case !! $this->request->bearerToken(): {
                $this->user = $this->provider->retrieveByToken(null, $this->request->bearerToken());
                break;
            }
            case
                !! $this->gatewayIdentifier &&
                !! $this->gatewayIdentifierSecret &&
                $this->gatewayIdentifierSecret === $this->configGatewaySecretKey: {
                $this->user = $this->provider->retrieveById($this->gatewayIdentifier);
                break;
            }
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
