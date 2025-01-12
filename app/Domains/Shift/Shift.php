<?php 
namespace App\Domains\Shift;

use App\Attributes\Getter;

use App\Domains\DomainEntity;
use App\Domains\Shared\Date;

class Shift extends DomainEntity {
    /**
     * @param int|null  $id
     * @param Date $date
     * @param int[] $dayShiftUserIds
     * @param int[] $lateShiftUserIds
     * @param int[] $nightShiftUserIds
     */
    private function __construct(
        #[Getter]
        private int|null $id = null,
        #[Getter]
        private Date $date,
        #[Getter]
        private array $dayShiftUserIds,
        #[Getter]
        private array $lateShiftUserIds,
        #[Getter]
        private array $nightShiftUserIds,
    ) {
    }
}