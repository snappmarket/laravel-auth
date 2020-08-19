<?php


namespace SnappMarket\LaravelAuth;


use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Container\Container;
use SnappMarket\Auth\Communicator;
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

    public function authorize($ability, $arguments = [])
    {
        $permission = new HasPermissionDto();
        $permission->setToken($arguments['token']);
        $permission->setPermission($arguments['permission']);
        $permission->setConstraint($arguments['constraint']);

        if (!$this->communicator->hasPermission($permission)) {
            return $this->deny();
        }

        return $this->allow();
    }
}