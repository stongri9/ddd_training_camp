<?php

namespace App\Domains\User;

use App\Models\User;
use App\Domains\User\User as UserEntity;

interface IUserRepository
{
    public function find(int $id): User|null;

    public function update(UserEntity $user): void;
}
