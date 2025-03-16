<?php

namespace Tests\Unit\Domains\Shift;

use app\Domains\Shift\ShiftChangeOriginAssignment;
use Tests\Factories\ShiftTestFactory;
use Tests\TestCase;

class ShiftChangeOriginAssignmentTest extends TestCase
{
    public function test_create_from_shift()
    {
        $shift = ShiftTestFactory::create(1, '2025-03-16', [1, 2, 3], [4, 5], [6]);

        $shiftChangeOriginAssignment = ShiftChangeOriginAssignment::createFromShift($shift);

        $this->assertEquals([1, 2, 3], $shiftChangeOriginAssignment->dayShiftUserIds);
        $this->assertEquals([4, 5], $shiftChangeOriginAssignment->lateShiftUserIds);
        $this->assertEquals([6], $shiftChangeOriginAssignment->nightShiftUserIds);
    }
}
