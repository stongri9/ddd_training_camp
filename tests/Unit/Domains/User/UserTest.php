<?php

namespace Tests\Unit\Domains\User;

use app\Domains\User\User;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    #[Test]
    public function createが実行されることでインスタンスが生成される(): void
    {
        $dayOffRequests = ['2025-01-01', '2025-01-02'];
        $user = User::create($dayOffRequests);
        $this->assertInstanceOf(User::class, $user);
        $this->assertCount(2, $user->dayOffRequests);
        $this->assertArrayHasKey(0, $user->dayOffRequests);
        $this->assertArrayHasKey(1, $user->dayOffRequests);
        if (isset($user->dayOffRequests[0])) {
            $this->assertEquals('2025-01-01', $user->dayOffRequests[0]->date->format('Y-m-d'));
        }
        if (isset($user->dayOffRequests[1])) {
            $this->assertEquals('2025-01-02', $user->dayOffRequests[1]->date->format('Y-m-d'));
        }
    }

    #[Test]
    public function updateを実行すると渡した引数で更新される(): void
    {
        $dayOffRequests = ['2025-01-01', '2025-01-02'];
        $user = User::create($dayOffRequests);
        $newDayOffRequests = ['2025-01-03', '2025-01-04'];
        $user->update($newDayOffRequests);

        $dayOffRequests = $user->dayOffRequests;

        $this->assertCount(2, $dayOffRequests);
        $this->assertArrayHasKey(0, $dayOffRequests);
        $this->assertArrayHasKey(1, $dayOffRequests);
        if (isset($dayOffRequests[0])) {
            $this->assertEquals('2025-01-03', $dayOffRequests[0]->date->format('Y-m-d'));
        }
        if (isset($dayOffRequests[1])) {
            $this->assertEquals('2025-01-04', $dayOffRequests[1]->date->format('Y-m-d'));
        }
    }
}
