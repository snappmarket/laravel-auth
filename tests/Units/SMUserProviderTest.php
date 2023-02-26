<?php

namespace SnappMarket\Tests\Units;

use SnappMarket\LaravelAuth\SMUser;
use SnappMarket\LaravelAuth\SMUserProvider;
use SnappMarket\Tests\TestCase;

class SMUserProviderTest extends TestCase
{

    /** @var SMUserProvider $smUserProvider */
    protected $smUserProvider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->smUserProvider = app(SMUserProvider::class);
    }

    public function userIdList()
    {
        return [
            [1],
            [2],
            [3],
            [4]
        ];
    }

    /**
     * @test
     * @dataProvider userIdList
     */
    public function retrieveById($userId) {
        $result = $this->smUserProvider->retrieveById($userId);
        $this->assertInstanceOf(SMUser::class, $result);
        $this->assertSame($result->getId(), $userId);
    }

}