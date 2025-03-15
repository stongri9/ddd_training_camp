<?php

namespace app\Domains\User;

class User
{
    /**
     * @param  DayOffRequest[]  $dayOffRequests
     * @param  Role  $role
     */
    private function __construct(
        public readonly ?int $id,
        public private(set) array $dayOffRequests,
        public private(set) Role $role,
    ) {}

    /**
     * @param  string[]  $dayOffRequests
     */
    public static function create(array $dayOffRequests, string $role): self
    {
        $role = Role::tryFrom($role);
        if (is_null($role)) {
            throw new \InvalidArgumentException('不正なロールです。');
        }

        return new self(
            null,
            self::createDayOffRequests($dayOffRequests),
            $role,
        );
    }

    /**
     * @param  string[]  $newDayOffRequests
     */
    public function updateDayOffRequests(array $newDayOffRequests): void
    {
        $this->dayOffRequests = $this->createDayOffRequests($newDayOffRequests);
    }

    /**
     * @return array{id: int|null, dayOffRequests: DayOffRequest[], role: string}
     */
    public function convertParams(): array
    {
        return [
            'id' => $this->id,
            'dayOffRequests' => $this->dayOffRequests,
            'role' => $this->role->value,
        ];
    }

    /**
     * @param  string[]  $dayOffRequests
     */
    public static function reconstruct(
        int $id,
        array $dayOffRequests,
        Role $role,
    ): self {
        $dayOffRequestsObjects = self::createDayOffRequests($dayOffRequests);

        return new self($id, $dayOffRequestsObjects, $role);
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
