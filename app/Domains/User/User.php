<?php 

namespace App\Domains\User;

use App\Domains\DomainEntity;

class User extends DomainEntity
{

    /**
     * @param int|null $id
     * @param DayOffRequest[] $dayOffRequests
     */
    private function __construct(
        #[Getter]
        private int|null $id,
        #[Getter]
        private array $dayOffRequests = []
    ) {
    }

    /**
     * @return App\Domains\DomainEntity\User
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
        $this->dayOffRequests = array_map(
            fn($newDayOffRequest) => new DayOffRequest($newDayOffRequest),
            $newDayOffRequests
        );
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
     * @param string[] $dayOffRequests
     */
    public static function reconstruct(
        int $id,
        array $dayOffRequests
    ): self {
        $dayOffRequestsObjects = array_map(
            fn($dayOffRequest) => new DayOffRequest($dayOffRequest),
            $dayOffRequests
        );
        return new self($id, $dayOffRequestsObjects);
    }
}