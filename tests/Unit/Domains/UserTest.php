<?php

namespace Tests\Unit\Domains;

use PHPUnit\Framework\TestCase;
use App\Domains\User\User;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    #[Test]
    public function createが実行されることでインスタンスが生成される(): void
    {
        $user = User::create();
        $this->assertInstanceOf(User::class, $user);
    }

    #[Test]
    public function updateを実行すると渡した引数で更新される(): void
    {
        $user = User::create();
        $user->update(['2025-01-01', '2025-01-02']);

        $dayOffRequests = $user->dayOffRequests;

        $this->assertCount(2, $dayOffRequests);
        $this->assertEquals('2025-01-01', $dayOffRequests[0]->date->format('Y-m-d'));
        $this->assertEquals('2025-01-02', $dayOffRequests[1]->date->format('Y-m-d'));
    }
}
