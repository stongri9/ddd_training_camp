<?php

namespace app\Domains\DayOffRequest;

class DayOffRequest
{
    /**
     * @param  DayOffRequestDay[] $day_off_request_days
     * @param  int $user_id
     * @param  int|null $id
     */
    private function __construct(
        public private(set) array $day_off_request_days,
        public readonly int $user_id,
        public readonly ?int $id = null
    ) {}

    /**
     * @param  string[] $day_off_request_days
     * @param int $user_id
     */
    public static function create(
        array $day_off_request_days,
        int $user_id,
    ): self {
        $dayOffRequestDays = array_map(
            fn (string $date) => DayOffRequestDay::create($date),
            $day_off_request_days
        );
    
        return new self(
            day_off_request_days: $dayOffRequestDays,
            user_id: $user_id,
        );
    }

    /**
     * @param  int $id
     * @param  string[] $day_off_request_days
     * @param int $user_id
     */
    public static function reconstruct(
        int $id,
        array $day_off_request_days,
        int $user_id,
    ): self {
        $dayOffRequestDays = array_map(
            fn (string $date) => DayOffRequestDay::create($date),
            $day_off_request_days
        );

        return new self(
            id: $id,
            day_off_request_days: $dayOffRequestDays,
            user_id: $user_id,
        );
    }

    /**
     * @param  string[] $day_off_request_days
     */
    public function update(
        array $day_off_request_days,
    ): void {
        $dayOffRequestDays = array_map(
            fn (string $date) => DayOffRequestDay::create($date),
            $day_off_request_days
        );

        $this->day_off_request_days = $dayOffRequestDays;
    }
}