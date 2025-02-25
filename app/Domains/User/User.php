<?php

namespace App\Domains\User;

class User
{
    /**
     * @param  DayOffRequest[]  $dayOffRequests
     */
    private function __construct(
        public readonly ?int $id,
        public private(set) array $dayOffRequests
    ) {
        $this->dayOffRequests = $this->createDayOffRequests($dayOffRequests);
    }

    public static function create(): self
    {
        return new self(
            null,
            [],
        );
    }

    /**
     * @param  DayOffRequest[]  $dayOffRequests
     */
    public function update(
        array $newDayOffRequests
    ): void {
        $this->dayOffRequests = $this->createDayOffRequests($newDayOffRequests);
    }

    public function convertParams(): array
    {
        return [
            'id' => $this->id,
            'dayOffRequests' => $this->dayOffRequests,
        ];
    }

    /**
     * @param  string[]  $dayOffRequests
     */
    public static function reconstruct(
        int $id,
        array $dayOffRequests
    ): self {
        $dayOffRequestsObjects = self::createDayOffRequests($dayOffRequests);

        return new self($id, $dayOffRequestsObjects);
    }

    /**
     * @param  string[]  $dayOffRequest
     * @return DayOffRequest[]
     */
    private static function createDayOffRequests(array $dayOffRequests): array
    {
        return array_map(
            fn ($dayOffRequest) => DayOffRequest::create($dayOffRequest),
            $dayOffRequests
        );
    }
}
