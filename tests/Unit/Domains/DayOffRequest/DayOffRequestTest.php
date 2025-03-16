<?php

namespace Tests\Unit\Domains\DayOffRequest;

use app\Domains\DayOffRequest\DayOffRequest;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DayOffRequestTest extends TestCase
{
    #[Test]
    public function createが実行されることでインスタンスが生成される(): void
    {
        // Arrange
        $day_off_request_days = ['2025-01-01', '2025-01-02'];
        $user_id = 1;

        // Act
        $day_off_request = DayOffRequest::create($day_off_request_days, $user_id);

        // Assert
        $this->assertInstanceOf(DayOffRequest::class, $day_off_request);
        $this->assertEquals(
            $day_off_request_days,
            array_map(fn ($day) => $day->value->format('Y-m-d'), $day_off_request->day_off_request_days)
        );
        $this->assertEquals($user_id, $day_off_request->user_id);
    }

    #[Test]
    public function updateを実行すると渡した引数で更新される(): void
    {
        // Arrange
        $day_off_request_days = ['2025-01-01', '2025-01-02'];
        $user_id = 1;
        $day_off_request = DayOffRequest::create($day_off_request_days, $user_id);

        // Act
        $new_day_off_request_days = ['2025-01-03', '2025-01-04'];
        $day_off_request->update($new_day_off_request_days);

        // Assert
        $this->assertEquals(
            $new_day_off_request_days,
            array_map(fn ($day) => $day->value->format('Y-m-d'), $day_off_request->day_off_request_days)
        );
    }

    #[Test]
    public function reconstructが実行されることでインスタンスが生成される(): void
    {
        // Arrange
        $day_off_request_days = ['2025-01-01', '2025-01-02'];
        $user_id = 1;

        // Act
        $day_off_request = DayOffRequest::reconstruct(
            id: 1,
            user_id: $user_id,
            day_off_request_days: $day_off_request_days,
        );

        // Assert
        $this->assertInstanceOf(DayOffRequest::class, $day_off_request);
        $this->assertEquals($user_id, $day_off_request->user_id);
        $this->assertEquals(
            $day_off_request_days,
            array_map(fn ($day) => $day->value->format('Y-m-d'), $day_off_request->day_off_request_days)
        );
    }
}
