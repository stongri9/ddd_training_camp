<?php

namespace Tests\Unit\Domains\DayOffRequest;

use app\Domains\DayOffRequest\DayOffRequestDate;
use DateMalformedStringException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DayOffRequestDateTest extends TestCase
{
    #[Test]
    public function createが実行されることでインスタンスが生成される(): void
    {
        $dayOffRequestDate = DayOffRequestDate::create('2025-01-01');
        $this->assertInstanceOf(DayOffRequestDate::class, $dayOffRequestDate);
        $this->assertEquals('2025-01-01', $dayOffRequestDate->date->format('Y-m-d'));
    }


    #[Test]
    public function reconstructが実行されることでインスタンスが生成される(): void
    {
        $dayOffRequestDate = DayOffRequestDate::reconstruct(new \DateTimeImmutable('2025-01-01'));
        $this->assertInstanceOf(DayOffRequestDate::class, $dayOffRequestDate);
        $this->assertEquals('2025-01-01', $dayOffRequestDate->date->format('Y-m-d'));
    }
}
