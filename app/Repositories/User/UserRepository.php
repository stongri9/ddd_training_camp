<?php

namespace app\Repositories\User;

use app\Domains\User\IUserRepository;
use app\Domains\User\Role;
use app\Domains\User\User;
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
     * @return Collection<int, User>
     */
    public function getUsersByIds(array $ids): Collection
    {
        return UserModel::whereIn('id', $ids)
            ->get()
            ->map(fn (UserModel $userModel) => User::reconstruct(
                $userModel->id,
                Role::from($userModel->role)
            )
            );
    }

    /**
     * @return Collection<int, User>
     */
    public function findAll(): Collection
    {
        return UserModel::all()->map(function (UserModel $userModel) {
            return User::reconstruct(
                $userModel->id,
                Role::from($userModel->role)
            );
        });
    }

    public function update(User $user): void
    {
        $model = UserModel::find($user->id);
        if ($model && is_a($model, UserModel::class)) {
            $model->fill($user->convertParams())->save();

            return;
        }

        throw new \Exception('ユーザーのデータが存在しません。');
    }
}
