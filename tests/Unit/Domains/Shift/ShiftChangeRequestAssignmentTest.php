<?php

namespace Tests\Unit\Domains\Shift;

use app\Domains\Shift\ShiftChangeRequestAssignment;
use Tests\TestCase;
use DateTimeImmutable;

class ShiftChangeRequestAssignmentTest extends TestCase
{
    public function test_create_shift_change_request_assignment()
    {
        $date = new DateTimeImmutable('2025-03-16');
        $dayShiftUserIds = [1, 2, 3];
        $lateShiftUserIds = [4, 5];
        $nightShiftUserIds = [6, 7];

        $shiftChangeRequestAssignment = ShiftChangeRequestAssignment::create(
            $date,
            $dayShiftUserIds,
            $lateShiftUserIds,
            $nightShiftUserIds
        );

        $this->assertEquals($dayShiftUserIds, $shiftChangeRequestAssignment->dayShiftUserIds);
        $this->assertEquals($lateShiftUserIds, $shiftChangeRequestAssignment->lateShiftUserIds);
        $this->assertEquals($nightShiftUserIds, $shiftChangeRequestAssignment->nightShiftUserIds);
    }

    public function test_create_shift_change_request_assignment_with_invalid_night_shift_count()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('夜勤の人は2人以上必要です。');

        $date = new DateTimeImmutable('2025-03-16');
        $dayShiftUserIds = [1, 2, 3];
        $lateShiftUserIds = [4, 5];
        $nightShiftUserIds = [6];

        ShiftChangeRequestAssignment::create(
            $date,
            $dayShiftUserIds,
            $lateShiftUserIds,
            $nightShiftUserIds
        );
    }

    public function test_create_shift_change_request_assignment_with_invalid_day_shift_for_holiday()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('休院日の場合、日勤の人は3人以上必要です。');

        $date = new DateTimeImmutable('2025-03-16');
        $dayShiftUserIds = [1, 2];
        $lateShiftUserIds = [4];
        $nightShiftUserIds = [6, 7];

        ShiftChangeRequestAssignment::create(
            $date,
            $dayShiftUserIds,
            $lateShiftUserIds,
            $nightShiftUserIds
        );
    }

    public function test_create_shift_change_request_assignment_with_invalid_day_shift_for_business_day()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('営業日の場合、日勤の人は4人以上必要です。');

        $date = new DateTimeImmutable('2025-03-17');
        $dayShiftUserIds = [1, 2, 3];
        $lateShiftUserIds = [4];
        $nightShiftUserIds = [6, 7];

        ShiftChangeRequestAssignment::create(
            $date,
            $dayShiftUserIds,
            $lateShiftUserIds,
            $nightShiftUserIds
        );
    }

    public function test_create_shift_change_request_assignment_with_invalid_late_shift_for_business_day()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('営業日の場合、遅番の人は1人以上必要です。');

        $date = new DateTimeImmutable('2025-03-17');
        $dayShiftUserIds = [1, 2, 3, 4];
        $lateShiftUserIds = [];
        $nightShiftUserIds = [6, 7];

        ShiftChangeRequestAssignment::create(
            $date,
            $dayShiftUserIds,
            $lateShiftUserIds,
            $nightShiftUserIds
        );
    }
}
