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
        $day_off_requests = ['2025-01-01', '2025-01-02'];
        $user = User::create($day_off_requests);
        $this->assertInstanceOf(User::class, $user);
        $this->assertCount(2, $user->day_off_requests);
        $this->assertArrayHasKey(0, $user->day_off_requests);
        $this->assertArrayHasKey(1, $user->day_off_requests);
        if (isset($user->day_off_requests[0])) {
            $this->assertEquals('2025-01-01', $user->day_off_requests[0]->date->format('Y-m-d'));
        }
        if (isset($user->day_off_requests[1])) {
            $this->assertEquals('2025-01-02', $user->day_off_requests[1]->date->format('Y-m-d'));
        }
    }

    #[Test]
    public function updateを実行すると渡した引数で更新される(): void
    {
        $day_off_requests = ['2025-01-01', '2025-01-02'];
        $user = User::create($day_off_requests);
        $newDayOffRequests = ['2025-01-03', '2025-01-04'];
        $user->update($newDayOffRequests);

        $day_off_requests = $user->day_off_requests;

        $this->assertCount(2, $day_off_requests);
        $this->assertArrayHasKey(0, $day_off_requests);
        $this->assertArrayHasKey(1, $day_off_requests);
        if (isset($day_off_requests[0])) {
            $this->assertEquals('2025-01-03', $day_off_requests[0]->date->format('Y-m-d'));
        }
        if (isset($day_off_requests[1])) {
            $this->assertEquals('2025-01-04', $day_off_requests[1]->date->format('Y-m-d'));
        }
    }
}
