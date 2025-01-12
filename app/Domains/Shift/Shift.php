<?php 
namespace App\Domains\Shift;

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
        private int|null $id = null,
        private Date $date,
        private array $dayShiftUserIds,
        private array $lateShiftUserIds,
        private array $nightShiftUserIds,
    ) {
    }
}