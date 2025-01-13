<?php

namespace App\Repositories\User;

use App\Domains\User\IUserRepository;
use App\Domains\User\User;
use \App\Models\User as UserModel;

class UserRepository implements IUserRepository
{
    /**
     * 1件取得
     * 
     * @param int $id
     * @return \App\Models\Inquiry
     */
    public function find(int $id): UserModel
    {
//         $model = UserModel::find($id);   
    }

    /**
     * アップデート処理
     * 
     * @param \App\Domains\User\User $ser
     * @return void
     */
    public function update(User $user): void {
        
    }
}