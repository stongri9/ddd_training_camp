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
        $day_off_request = DayOffRequest::create(date: '2025-01-01');
        $this->assertInstanceOf(DayOffRequest::class, $day_off_request);
        $this->assertNull($day_off_request->id);
        $this->assertEquals('2025-01-01', $day_off_request->date->format('Y-m-d'));
    }

    #[Test]
    public function reconstructが実行されることでインスタンスが生成される(): void
    {
        $day_off_request = DayOffRequest::reconstruct(
            date: '2025-01-01',
            id: 1,
        );
        $this->assertInstanceOf(DayOffRequest::class, $day_off_request);
        $this->assertEquals(1, $day_off_request->id);
        $this->assertEquals('2025-01-01', $day_off_request->date->format('Y-m-d'));
    }
}
