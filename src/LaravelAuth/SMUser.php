<?php

namespace SnappMarket\LaravelAuth;

use Illuminate\Contracts\Auth\Authenticatable;
use SnappMarket\Auth\Responses\Parts\Access;

class SMUser implements Authenticatable
{
    /** @var int */
    private $id;

    /** @var string */
    private $token;


    /**
     * @var array|Access
     */
    protected $accessInfo = [];

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        // TODO: Implement getAuthPassword() method.
    }

    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }



    /**
     * @return array|Access
     */
    public function getAccessInfo()
    {
        return $this->accessInfo;
    }



    /**
     * @param array|Access $accessInfo
     */
    public function setAccessInfo($accessInfo): void
    {
        $this->accessInfo = $accessInfo;
    }
}
