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
            self::Day => '日勤',
            self::Late => '夕勤',
            default => '夜勤',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Day => 'red',
            self::Late => 'green',
            default => 'blue',
        };
    }
}
