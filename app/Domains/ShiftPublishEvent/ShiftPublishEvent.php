<?php

namespace app\Domains\ShiftPublishEvent;

class ShiftPublishEvent
{
  /**
   * @param string $start_date
   * @param string $end_date
   */
  private function __construct(
    public readonly string $start_date,
    public readonly string $end_date,
  ) {}

  public static function create(string $start_date, string $end_date): self
  {
    return new self($start_date, $end_date);
  }
}
