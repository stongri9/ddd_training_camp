<?php

namespace app\Domains\Shift;

enum ShiftType: string
{
    case Day = 'Day';
    case Late = 'Late';
    case Night = 'Night';

    public function label(): string
    {
        return match ($this) {
            ShiftType::Day => '日勤',
            ShiftType::Late => '夕勤',
            default => '夜勤',
        };
    }
}
