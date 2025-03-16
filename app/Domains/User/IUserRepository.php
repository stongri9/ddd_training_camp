<?php

namespace app\Domains\User;

use app\Models\User as UserModel;
use Illuminate\Support\Collection;

interface IUserRepository
{
    public function find(int $id): ?UserModel;

    /**
     * @param  int[]  $ids
     * @return Collection<int, UserModel>
     */
    public function getUsersByIds(array $ids): Collection;

    /**
     * @return Collection<int, UserModel>
     */
    public function findAll(): Collection;
}
