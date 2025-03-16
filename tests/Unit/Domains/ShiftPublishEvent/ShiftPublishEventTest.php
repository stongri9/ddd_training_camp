<?php

namespace Tests\Unit\Domains\ShiftPublishEvent;

use app\Domains\ShiftPublishEvent\ShiftPublishEvent;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShiftPublishEventTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function createが実行されることでインスタンスが生成される(): void
    {
        // Arrange
        $start_date = '2025-01-01';
        $end_date = '2025-01-02';

        // Act
        $shift_publish_event = ShiftPublishEvent::create($start_date, $end_date);

        // Assert
        $this->assertInstanceOf(ShiftPublishEvent::class, $shift_publish_event);
        $this->assertEquals($start_date, $shift_publish_event->start_date);
        $this->assertEquals($end_date, $shift_publish_event->end_date);
    }
}
