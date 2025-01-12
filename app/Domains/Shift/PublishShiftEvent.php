<?php

namespace App\Domains\Shift;

use App\Attributes\Getter;
use App\Domains\DomainEntity;
use DateTimeImmutable;

class PublishShiftEvent extends DomainEntity
{
    /**
    * @param int|null $id
    * @param int $shiftId
    * @param DateTimeImmutable $date
    */
    private function __construct(
      #[Getter]
      private int|null $id,
      #[Getter]
      private int $shiftId,
      #[Getter]
      private DateTimeImmutable $date,
      #[Getter]
      private int $createdUserId
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