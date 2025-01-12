<?php 

namespace App\Domains\Shared;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class Date {
    /**
     * @param string $value
     * @throws \InvalidArgumentException
     */
    private function __construct(
        public readonly string $value,
    ) {
        try {
            $value = Carbon::parse($value)->format('y-m-d');
        } catch (InvalidFormatException $e) {
            throw new \InvalidArgumentException(
                '日付の形式が不正です。'
            );
        }
    }

    /**
     * @param string $date
     * @return \App\Domains\Shared\Date
     */
    public static function create(string $date): self 
    {
        return new self($date);
    }
}