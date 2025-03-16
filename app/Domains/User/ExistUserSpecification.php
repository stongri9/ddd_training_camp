<?php

namespace app\Domains\User;

use app\Domains\User\IUserRepository;

class ExistUserSpecification
{
  public function __construct(
    private readonly IUserRepository $userRepository,
  ) {}

  public function isSatisfied(int $userId): bool
  {
    return !is_null($this->userRepository->find($userId));
  }
}