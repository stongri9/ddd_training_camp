<?php 

namespace App\Domains\Shared;

class Date {
    /**
     * @param string $value
     * @throws \InvalidArgumentException
     */
    private function __construct(
        public readonly string $value,
    ) {
        try {
            $this->value = (new \DateTimeImmutable($value))->format('Y-m-d');
        } catch (\Exception $e) {
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