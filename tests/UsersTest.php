<?php

namespace App\Tests;

use App\actions\Users;
use App\User;

class UsersTest extends BaseTest
{
    public function setUp(): void
    {
        parent::setUp();

        $this->factory->create(User::class);
        $this->factory->create(User::class);
    }

    public function testIndex()
    {
        $users = Users::index();
        $this->assertCount(4, $users);
    }

    public function testCreate()
    {
        $params = $this->factory->make(User::class)->toArray();
        $expected = collect($params)->except('password')->toArray();
        $user = Users::create($params);
        $actual = collect($user->toArray())
            ->except('password', 'created_at', 'updated_at', 'id')
            ->toArray();
        $this->assertEquals($expected, $actual);
    }

    public function testUpdate()
    {
        $user = $this->factory->create(User::class);
        $params = $this->factory->make(User::class)->toArray();
        $expected = collect($params)->except('password')->toArray();
        $user = Users::update($user->id, $params);
        $actual = collect($user->toArray())
            ->except('password', 'created_at', 'updated_at', 'id')
            ->toArray();
        $this->assertEquals($expected, $actual);
    }

    public function testDelete()
    {
        $user = $this->factory->create(User::class);
        $result = Users::delete($user->id);
        $this->assertTrue($result);
        $result2 = Users::delete($user->id);
        $this->assertFalse($result2);

        $user2 = User::find($user->id);

        $this->assertNull($user2);
    }
}
