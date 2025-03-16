<?php

namespace Tests\Unit\Domains\User;

use app\Domains\DayOffRequest\DayOffRequest;
use app\Domains\DayOffRequest\DayOffRequestDate;
use app\Domains\DayOffRequest\DayOffRequestDateCollection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DayOffRequestTest extends TestCase
{
    #[Test]
    public function createが実行されることでインスタンスが生成される(): void
    {
        $dayOffRequestDateCollection = DayOffRequestDateCollection::create([
            DayOffRequestDate::create('2025-01-01'),
            DayOffRequestDate::create('2025-01-02'),
            DayOffRequestDate::create('2025-01-03'),
        ]);

        $dayOffRequest = DayOffRequest::create(1, 1, $dayOffRequestDateCollection);

        $this->assertInstanceOf(DayOffRequest::class, $dayOffRequest);
        $this->assertEquals(1, $dayOffRequest->id);
        $this->assertEquals(1, $dayOffRequest->user_id);
        $this->assertEquals($dayOffRequestDateCollection, $dayOffRequest->dayOffRequestDateCollection);
    }

    #[Test]
    public function reconstructが実行されることでインスタンスが生成される(): void
    {
        $dayOffRequestDateCollection = DayOffRequestDateCollection::create([
            DayOffRequestDate::create('2025-01-01'),
            DayOffRequestDate::create('2025-01-02'),
            DayOffRequestDate::create('2025-01-03'),
        ]);

        $dayOffRequest = DayOffRequest::reconstruct(
            1,
            1,
            $dayOffRequestDateCollection
        );
        $this->assertInstanceOf(DayOffRequest::class, $dayOffRequest);
        $this->assertEquals(1, $dayOffRequest->id);
        $this->assertEquals(1, $dayOffRequest->user_id);
        $this->assertEquals('2025-01-01', $dayOffRequestDateCollection->dayOffRequestDates[0]->date->format('Y-m-d'));
        $this->assertEquals('2025-01-02', $dayOffRequestDateCollection->dayOffRequestDates[1]->date->format('Y-m-d'));
        $this->assertEquals('2025-01-03', $dayOffRequestDateCollection->dayOffRequestDates[2]->date->format('Y-m-d'));
    }
}
