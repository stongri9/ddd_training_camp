<?php

namespace app\Domains\User;

class User
{
    /**
     * @param  DayOffRequest[]  $day_off_requests
     */
    private function __construct(
        public private(set) array $day_off_requests,
        public readonly ?int $id = null,
    ) {}

    /**
     * @param  string[]  $day_off_requests
     */
    public static function create(array $day_off_requests): self
    {
        return new self(
            day_off_requests: self::createDayOffRequests($day_off_requests)
        );
    }

    /**
     * @param  string[]  $new_day_off_requests
     */
    public function update(array $new_day_off_requests): void
    {
        $this->day_off_requests = $this->createDayOffRequests(
            $new_day_off_requests,
        );
    }

    /**
     * @return array{day_off_requests: DayOffRequest[], id: int|null}
     */
    public function convertParams(): array
    {
        return [
            'id' => $this->id,
            'day_off_requests' => $this->day_off_requests,
        ];
    }

    /**
     * @param  string[]  $day_off_requests
     */
    public static function reconstruct(
        int $id,
        array $day_off_requests
    ): self {
        $dayOffRequestsObjects = self::createDayOffRequests(
            $day_off_requests,
        );

        return new self($dayOffRequestsObjects, $id);
    }

    /**
     * @param  string[]  $day_off_requests
     * @return DayOffRequest[]
     */
    private static function createDayOffRequests(
        array $day_off_requests,
    ): array {
        return array_map(
            fn ($day_off_request) => DayOffRequest::create(
                $day_off_request
            ),
            $day_off_requests
        );
    }
}
