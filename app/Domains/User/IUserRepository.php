<?php 

namespace App\Domains\User;

use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Collection;

interface IUserRepository {
    public function find(int $id): UserModel|null;
    public function update(User $user): void;
    public function getUsersByIds(array $ids): Collection;
    public function findAll(): Collection;
}