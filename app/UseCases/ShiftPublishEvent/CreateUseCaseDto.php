<?php

namespace app\UseCases\ShiftPublishEvent;

class CreateUseCaseDto
{
  private function __construct(
    public readonly string $start_date,
    public readonly string $end_date,
  ) {}

  public static function create(
    string $start_date,
    string $end_date,
  ): self {
    return new self($start_date, $end_date);
  }
}
