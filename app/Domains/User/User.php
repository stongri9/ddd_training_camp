<?php 

namespace App\Domains\User;

use App\Domains\DomainEntity;


class User extends DomainEntity {

    /**
     * @param int|null $id
     * @param array $dayOffRequests
     */
    private function __construct(
        #[Getter]
        private int $id,
        #[Getter]
        private array $dayOffRequests = []
    ) {
    }


    public function update(
        array $dayOffRequests
    ): void {
        $this->dayOffRequests = $dayOffRequests;
    }

    /**
     * @return array
     */
    public function convertParams():array {
        return [
            'id' => $this->id,
            'dayOffRequests' => $this->dayOffRequests
        ];
    }
}