<?php

namespace app\Repositories\User;

use app\Domains\User\IUserRepository;
use app\Domains\User\User;
use app\Models\DayOffRequest;
use app\Models\User as UserModel;
use Illuminate\Support\Collection;

class UserRepository implements IUserRepository
{
    public function find(int $id): ?UserModel
    {
        return UserModel::find($id);
    }

    /**
     * @param  int[]  $ids
     * @return Collection<int, UserModel>
     */
    public function getUsersByIds(array $ids): Collection
    {
        return UserModel::whereIn('id', $ids)->get();
    }

    /**
     * @return Collection<int, UserModel>
     */
    public function findAll(): Collection
    {
        return UserModel::all();
    }
}
