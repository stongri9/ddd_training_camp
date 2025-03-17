<?php

namespace app\Domains\ShiftChangeApplicationResult;

enum ResultType: string
{
    case Approved = 'Approved';
    case Rejected = 'Rejected';

    public function label(): string
    {
        return match ($this) {
            ResultType::Approved => '承認',
            default => '却下',
        };
    }
}
