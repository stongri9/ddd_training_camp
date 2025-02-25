<?php

namespace App\Domains\User;

use App\Models\User as UserModel;

interface IUserRepository
{
    public function find(int $id): ?UserModel;

    public function update(User $user): void;
}
