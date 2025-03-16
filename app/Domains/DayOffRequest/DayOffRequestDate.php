<?php

namespace app\Domains\DayOffRequest;

use DateTimeImmutable;

class DayOffRequestDate
{
    /**
     * @param  \DateTimeImmutable  $date
     */
    private function __construct(
        public readonly \DateTimeImmutable $date
    ) {}

    public static function create(string $date): self
    {
        try {
            $date = new \DateTimeImmutable($date);
        } catch (\Exception $e) {
            print_r($e);
            throw new \Exception('不正な休み希望日です。');
        }
        return new self(new \DateTimeImmutable($date->format('Y-m-d')));
    }

    public static function reconstruct(\DateTimeInterface $date): self
    {
        return new self(new \DateTimeImmutable($date->format('Y-m-d')));
    }
}
