<?php


namespace SnappMarket\LaravelAuth;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use SnappMarket\Auth\Communicator;
use SnappMarket\Auth\DataContracts\LoginByUsernameDto;
use SnappMarket\LaravelAuth\SMUser;

class SMUserProvider implements UserProvider
{

    /**
     * @var Communicator
     */
    private $communicator;

    public function __construct(Communicator $communicator)
    {
        $this->communicator = $communicator;
    }

    public function retrieveById($identifier)
    {
        $user = new SMUser();
        $user->setId($identifier);

        return $user;
    }

    public function retrieveByToken($identifier, $token)
    {
        $response = $this->communicator->authenticate($token);

        $user = new SMUser();
        $user->setId($response->getUserId());
        $user->setToken($response->getToken());
        $user->setAccessInfo($response->getAccessInfo());

        return $user;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
    }

    public function retrieveByCredentials(array $credentials)
    {
        $loginDto = new LoginByUsernameDto();
        $loginDto->setUsername($credentials['username']);
        $loginDto->setPassword($credentials['password']);

        $loginResponse = $this->communicator->loginByUsername($loginDto);
        $authResponse  = $this->communicator->authenticate($loginResponse->getToken());

        $user = new SMUser();
        $user->setId($authResponse->getUserId());
        $user->setToken($authResponse->getToken());
        $user->setAccessInfo($authResponse->getAccessInfo());

        return $user;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // TODO: Implement validateCredentials() method.
    }
}
