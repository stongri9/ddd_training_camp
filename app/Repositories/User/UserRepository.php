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

    public function update(User $user): void
    {
        $userModel = UserModel::find($user->id);

        // 休み希望の洗い替えのため既存データを削除
        DayOffRequest::where('user_id', $userModel->id)->delete();
        // 新しい休み希望を登録
        foreach ($user->dayOffRequests as $dayOffRequest) {
            DayOffRequest::create([
                'user_id' => $userModel->id,
                'date' => $dayOffRequest->date,
            ]);
        }
    }
}
