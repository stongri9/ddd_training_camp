<?php

namespace app\Domains\User;

use app\Models\User as UserModel;
use Illuminate\Support\Collection;

interface IUserRepository
{
    public function find(int $id): ?UserModel;

    public function update(User $user): void;

    /**
     * @param  int[]  $ids
     * @return Collection<int, User>
     */
    public function getUsersByIds(array $ids): Collection;

    /**
     * @return Collection<int, User>
     */
    public function findAll(): Collection;
}
