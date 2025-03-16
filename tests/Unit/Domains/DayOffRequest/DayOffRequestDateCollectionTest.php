<?php

namespace Tests\Unit\Domains\DayOffRequest;

use app\Domains\DayOffRequest\DayOffRequestDate;
use app\Domains\DayOffRequest\DayOffRequestDateCollection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DayOffRequestDateCollectionTest extends TestCase
{
    #[Test]
    public function createが実行されることでインスタンスが生成される(): void
    {
        $dayOffRequestDates = [
            DayOffRequestDate::create('2025-01-01'),
            DayOffRequestDate::create('2025-01-02'),
            DayOffRequestDate::create('2025-01-03'),
        ];

        $dayOffRequestDateCollection = DayOffRequestDateCollection::create($dayOffRequestDates);
        $this->assertInstanceOf(DayOffRequestDateCollection::class, $dayOffRequestDateCollection);
        $this->assertEquals('2025-01-01', $dayOffRequestDateCollection->dayOffRequestDates[0]->date->format('Y-m-d'));
        $this->assertEquals('2025-01-02', $dayOffRequestDateCollection->dayOffRequestDates[1]->date->format('Y-m-d'));
        $this->assertEquals('2025-01-03', $dayOffRequestDateCollection->dayOffRequestDates[2]->date->format('Y-m-d'));
    }


    #[Test]
    public function reconstructが実行されることでインスタンスが生成される(): void
    {
        $dayOffRequest = DayOffRequestDate::reconstruct(new \DateTimeImmutable('2025-01-01'));
        $this->assertInstanceOf(DayOffRequestDate::class, $dayOffRequest);
        $this->assertEquals('2025-01-01', $dayOffRequest->date->format('Y-m-d'));
    }
}
