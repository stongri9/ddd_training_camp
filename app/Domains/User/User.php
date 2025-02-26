<?php

namespace App\Domains\User;

class User
{
    /**
     * @param int|null $id
     * @param DayOffRequest[] $dayOffRequests
     */
    private function __construct(
        public readonly ?int $id,
        public private(set) array $dayOffRequests,
    ) {}

    /**
     * @param string[] $dayOffRequests
     * @return User
     */
    public static function create(array $dayOffRequests): self
    {
        return new self(
            null,
            self::createDayOffRequests($dayOffRequests),
        );
    }

    /**
     * @param  string[]  $newDayOffRequests
     */
    public function update(array $newDayOffRequests): void 
    {
        $this->dayOffRequests = $this->createDayOffRequests($newDayOffRequests);
    }

    /**
     * @return array{dayOffRequests: DayOffRequest[], id: int|null}
     */
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
     * @param  string[]  $dayOffRequests
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
