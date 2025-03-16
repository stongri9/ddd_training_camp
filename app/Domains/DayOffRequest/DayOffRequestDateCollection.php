<?php

namespace app\Domains\DayOffRequest;

class DayOffRequestDateCollection
{
    /**
     * @param array<int, DayOffRequestDate> $dayOffRequestDates
     */
    private function __construct(public readonly array $dayOffRequestDates)
    {}

    /**
     * @param array<int, mixed> $dayOffRequestDates
     * @return self
     * @throws \Exception
     */    
    public static function create(array $dayOffRequestDates): self
    {
        /** @var array<int, DayOffRequestDate> $validatedDates */
        $validatedDates = [];
        
        foreach ($dayOffRequestDates as $date) {
            if (!$date instanceof DayOffRequestDate) {
                throw new \Exception('不正な休み希望日です。');
            }
            $validatedDates[] = $date;
        }

        return new self($validatedDates);
    }
}