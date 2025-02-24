<?php 

namespace App\Domains\User;

use App\Domains\User\DayOffRequest;

class User
{
    /**
     * @param int|null $id
     * @param DayOffRequest[] $dayOffRequests
     */
    private function __construct(
        public private(set) int|null $id,
        public private(set) array $dayOffRequests
    ) {
        $this->dayOffRequests = $this->createDayOffRequests($dayOffRequests);
    }

    /**
     * @return self
     */
    public static function create(): self
    {
        return new self(
            null,
            [],
        );
    }

    /**
     * @param DayOffRequest[] $dayOffRequests
     * @return void
     */
    public function update(
        array $newDayOffRequests
    ): void {
        $this->dayOffRequests = $this->createDayOffRequests($newDayOffRequests);
    }

    /**
     * @return array
     */
    public function convertParams(): array 
    {
        return [
            'id' => $this->id,
            'dayOffRequests' => $this->dayOffRequests
        ];
    }

    /**
     * @param int $id
     * @param string[] $dayOffRequests
     */
    public static function reconstruct(
        int $id,
        array $dayOffRequests
    ): self {
        $dayOffRequestsObjects = self::createDayOffRequests($dayOffRequests);
        return new self($id, $dayOffRequestsObjects);
    }

    /**
     * @param string[] $dayOffRequest
     * @return DayOffRequest[]
     */
    private static function createDayOffRequests(array $dayOffRequests): array
    {
        return array_map(
            fn($dayOffRequest) => DayOffRequest::create($dayOffRequest),
            $dayOffRequests
        );
    }
}