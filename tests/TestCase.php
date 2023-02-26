<?php

namespace SnappMarket\Tests;


use Orchestra\Testbench\TestCase as BaseTestCase;
use SnappMarket\LaravelAuth\SMAuthServiceProvider;
use SnappMarket\LaravelAuth\SMUserProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SMAuthServiceProvider::class
        ];
    }
}