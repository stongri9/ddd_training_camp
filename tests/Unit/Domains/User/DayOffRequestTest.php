<?php

namespace Tests\Unit\Domains\User;

use app\Domains\User\DayOffRequest;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DayOffRequestTest extends TestCase
{
    #[Test]
    public function createが実行されることでインスタンスが生成される(): void
    {
        $dayOffRequest = DayOffRequest::create(1, '2025-01-01');
        $this->assertInstanceOf(DayOffRequest::class, $dayOffRequest);
        $this->assertNull($dayOffRequest->id);
        $this->assertEquals(1, $dayOffRequest->user_id);
        $this->assertEquals('2025-01-01', $dayOffRequest->date->format('Y-m-d'));
    }

    #[Test]
    public function reconstructが実行されることでインスタンスが生成される(): void
    {
        $dayOffRequest = DayOffRequest::reconstruct(
            1,
            1,
            '2025-01-01'
        );
        $this->assertInstanceOf(DayOffRequest::class, $dayOffRequest);
        $this->assertEquals(1, $dayOffRequest->id);
        $this->assertEquals(1, $dayOffRequest->user_id);
        $this->assertEquals('2025-01-01', $dayOffRequest->date->format('Y-m-d'));
    }
}
