<?php

namespace app\Domains\User;

use app\Models\User as UserModel;
use Illuminate\Support\Collection;

interface IUserRepository
{
    /**
     * @param  int  $id
     * @return UserModel|null
     */
    public function find(int $id): ?UserModel;

    /**
     * @param  User  $user
     * @return void
     */
    public function update(User $user): void;

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
