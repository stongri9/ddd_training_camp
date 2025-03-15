<?php

namespace app\Domains\User;

class User
{
    /**
     * @param  DayOffRequest[]  $dayOffRequests
     */
    private function __construct(
        public readonly ?int $id,
        public private(set) array $dayOffRequests,
    ) {}

    /**
     * @param  string[]  $dayOffRequests
     */
    public static function create(array $dayOffRequests): self
    {
        return new self(
            null,
            self::createDayOffRequests($dayOffRequests, null)
        );
    }

    /**
     * @param  string[]  $newDayOffRequests
     */
    public function update(array $newDayOffRequests): void
    {
        $this->dayOffRequests = $this->createDayOffRequests(
            $newDayOffRequests,
            $this->id
        );
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
        $dayOffRequestsObjects = self::createDayOffRequests(
            $dayOffRequests,
            $id
        );

        return new self($id, $dayOffRequestsObjects);
    }

    /**
     * @param  string[]  $dayOffRequests
     * @return DayOffRequest[]
     */
    private static function createDayOffRequests(
        array $dayOffRequests,
        ?int $user_id = null
    ): array {
        return array_map(
            fn ($dayOffRequest) => DayOffRequest::create(
                $user_id,
                $dayOffRequest
            ),
            $dayOffRequests
        );
    }
}
