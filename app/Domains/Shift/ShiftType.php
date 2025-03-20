<?php

namespace app\Domains\Shift;

enum ShiftType: string
{
    case Day = 'Day';
    case Late = 'Late';
    case Night = 'Night';

    /**
     * @return string
     * @throws \DomainException 
     */
    public function label(): string
    {
        return match ($this) {
            self::Day => '日勤',
            self::Late => '夕勤',
            self::Night => '夜勤',
            default => throw new \DomainException('存在しないShiftTypeです'),
        };
    }

    /**
     * @return string
     * @throws \DomainException 
     */
    public function color(): string
    {
        return match($this) {
            self::Day => 'red',
            self::Late => 'green',
            self::Night => 'blue',
            default => throw new \DomainException('存在しないShiftTypeです'),
        };
    }
}
