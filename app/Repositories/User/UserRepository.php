<?php

namespace App\Repositories\User;

use App\Domains\User\IUserRepository;
use App\Domains\User\User;
use App\Models\DayOffRequest;
use App\Models\User as UserModel;

class UserRepository implements IUserRepository
{
    public function find(int $id): ?UserModel
    {
        return UserModel::find($id);
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
