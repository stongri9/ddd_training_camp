<?php

namespace Tests\Unit\Domains\Shift;

use app\Domains\Shift\ShiftChangeApplication;
use app\Domains\Shift\ShiftChangeOriginAssignment;
use app\Domains\Shift\ShiftChangeRequestAssignment;
use DateTimeImmutable;
use Tests\Factories\ShiftTestFactory;
use Tests\TestCase;

class ShiftChangeApplicationTest extends TestCase
{
    public function test_create_shift_change_application()
    {
        $date = new DateTimeImmutable('2025-03-16');
        $shift = ShiftTestFactory::create(
            id: 1,
            date: $date,
            dayShiftUserIds: [1, 2, 3],
            lateShiftUserIds: [4, 5],
            nightShiftUserIds: [6, 7]
        );

        $requestDayShiftUserIds = [8, 9, 10];
        $requestLateShiftUserIds = [11, 12];
        $requestNightShiftUserIds = [13, 14];
        $userId = 10;
        $comment = 'シフト変更お願いします！';

        $shiftChangeApplication = ShiftChangeApplication::create(
            $shift,
            $date,
            $requestDayShiftUserIds,
            $requestLateShiftUserIds,
            $requestNightShiftUserIds,
            $userId,
            $comment
        );

        // Assert（検証）
        $this->assertNull($shiftChangeApplication->id);
        $this->assertEquals($date, $shiftChangeApplication->date);
        $this->assertEquals($userId, $shiftChangeApplication->userId);
        $this->assertEquals($comment, $shiftChangeApplication->comment);

        // 元シフト割り当ての確認
        $originAssignment = $shiftChangeApplication->shiftChangeOriginAssignment;
        $this->assertInstanceOf(ShiftChangeOriginAssignment::class, $originAssignment);
        $this->assertEquals([1, 2, 3], $originAssignment->dayShiftUserIds);
        $this->assertEquals([4, 5], $originAssignment->lateShiftUserIds);
        $this->assertEquals([6, 7], $originAssignment->nightShiftUserIds);

        // 希望シフト割り当ての確認
        $requestAssignment = $shiftChangeApplication->shiftChangeRequestAssignment;
        $this->assertInstanceOf(ShiftChangeRequestAssignment::class, $requestAssignment);
        $this->assertEquals($requestDayShiftUserIds, $requestAssignment->dayShiftUserIds);
        $this->assertEquals($requestLateShiftUserIds, $requestAssignment->lateShiftUserIds);
        $this->assertEquals($requestNightShiftUserIds, $requestAssignment->nightShiftUserIds);
    }
}
