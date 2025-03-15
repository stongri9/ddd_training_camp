<?php

namespace app\Domains\User;

use app\Models\User as UserModel;
use Illuminate\Support\Collection;

interface IUserRepository
{
    public function find(int $id): ?UserModel;

    public function update(User $user): void;

    public function getUsersByIds(array $ids): Collection;

    public function findAll(): Collection;
}
