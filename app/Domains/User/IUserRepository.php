<?php

namespace App\Domains\User;

use App\Models\User as UserModel;
use App\Domains\User\User;

interface IUserRepository
{
    public function find(int $id): UserModel|null;

    public function update(User $user): void;
}
