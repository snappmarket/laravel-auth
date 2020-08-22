<?php


namespace SnappMarket\LaravelAuth;


use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Container\Container;
use SnappMarket\Auth\Communicator;
use SnappMarket\Auth\DataContracts\HasAllPermissionsDto;
use SnappMarket\Auth\DataContracts\HasPermissionDto;

class SMGate extends \Illuminate\Auth\Access\Gate
{
    /**
     * @var Communicator
     */
    private $communicator;

    public function __construct(Communicator $communicator, Container $container, callable $userResolver, array $abilities = [],
                                array $policies = [], array $beforeCallbacks = [], array $afterCallbacks = [],
                                callable $guessPolicyNamesUsingCallback = null)
    {
        parent::__construct($container, $userResolver, $abilities, $policies, $beforeCallbacks, $afterCallbacks, $guessPolicyNamesUsingCallback);
        $this->communicator = $communicator;
    }

    public function check($abilities, $arguments = [])
    {
        $checkDto = new HasAllPermissionsDto();
        $checkDto->setToken($arguments['token']);
        $checkDto->setPermissions($abilities);
        $checkDto->setConstraints($arguments['constraints'] ?? []);

        return $this->communicator->hasAllPermissions($checkDto);
    }
}
