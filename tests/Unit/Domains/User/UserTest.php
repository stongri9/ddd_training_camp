<?php

namespace Tests\Unit\Domains\User;

use App\Domains\User\User;
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
        $this->assertEquals('2025-01-01', $user->dayOffRequests[0]->date->format('Y-m-d'));
        $this->assertEquals('2025-01-02', $user->dayOffRequests[1]->date->format('Y-m-d'));
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
        $this->assertEquals('2025-01-03', $dayOffRequests[0]->date->format('Y-m-d'));
        $this->assertEquals('2025-01-04', $dayOffRequests[1]->date->format('Y-m-d'));
    }
}
