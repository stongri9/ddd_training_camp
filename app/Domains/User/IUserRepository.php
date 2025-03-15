<?php

namespace app\Domains\User;

use Illuminate\Support\Collection;

interface IUserRepository
{
    public function find(int $id): ?User;

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
