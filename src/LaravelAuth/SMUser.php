<?php

namespace SnappMarket\LaravelAuth\DataContracts;

use Illuminate\Contracts\Auth\Authenticatable;

class SMUser implements Authenticatable
{
    /** @var int */
    private $id;

    /** @var string */
    private $token;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
}