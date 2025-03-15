<?php

namespace App\Domains\User;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\DayOffRequestFactory;

class DayOffRequest
{
    use HasFactory;
    
    private function __construct(public DateTimeImmutable $date) {}

    public static function create(string $date): self
    {
        return new self(new DateTimeImmutable($date));
    }

    public static function reconstruct(string $date): self
    {
        return new self(new DateTimeImmutable($date));
    }

    protected static function newFactory()
    {
        return DayOffRequestFactory::new();
    }
}
