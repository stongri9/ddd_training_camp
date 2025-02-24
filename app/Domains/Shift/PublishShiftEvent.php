<?php

namespace App\Domains\Shift;

use App\Attributes\Getter;
use App\Domains\DomainEntity;
use DateTimeImmutable;

class PublishShiftEvent
{
    /**
    * @param int|null $id
    * @param int $shiftId
    * @param DateTimeImmutable $date
    */
    private function __construct(
      public private(set) int|null $id,
      public private(set) int $shiftId,
      public private(set) DateTimeImmutable $date,
      public private(set) int $createdUserId
    ) {
    }

    /**
     * @param int $shiftId
     * @param string $date
     * @return App\Domains\Shift\PublishShiftEvent
     */
    public static function create(
      int $shiftId,
      string $date,
      int $createdUserId
    ): self {
          return new self(
              null,
              $shiftId,
              new DateTimeImmutable($date),
              $createdUserId
          );
    }

    /**
     * @param int $id
     * @param int $shiftId
     * @param string $date
     * @return App\Domains\Shift\PublishShiftEvent
     */
    public static function reconstruct(
      int $id,
      int $shiftId,
      string $date,
      int $createdUserId
    ): self {
          return new self(
              $id,
              $shiftId,
              new DateTimeImmutable($date),
              $createdUserId
          );
    }
}