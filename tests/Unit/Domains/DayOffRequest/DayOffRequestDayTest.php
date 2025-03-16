<?php

namespace Tests\Unit\Domains\DayOffRequest;

use app\Domains\DayOffRequest\DayOffRequestDay;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DayOffRequestDayTest extends TestCase
{
    #[Test]
    public function createメソッドで値オブジェクトが生成されること(): void
    {
        $dayOffRequestDay = DayOffRequestDay::create('2025-01-01');

        $this->assertEquals(new DateTimeImmutable('2025-01-01'), $dayOffRequestDay->value);
    }
}
