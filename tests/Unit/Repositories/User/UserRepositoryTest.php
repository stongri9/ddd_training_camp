<?php

namespace Tests\Unit\Repositories\User;

use app\Domains\User\Role;
use app\Models\User as UserModel;
use app\Repositories\User\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_all_returns_users_entities()
    {
        $userModel = UserModel::factory()->create([
            'role' => Role::Nurse->value,
        ]);
        $repository = new UserRepository;

        $users = $repository->findAll();
        $this->assertCount(1, $users);

        $user = $users->first();
        $this->assertSame($userModel->id, $user->id);

        $this->assertInstanceOf(Role::class, $user->role);
        $this->assertSame(Role::Nurse->value, $user->role->value);
    }
}
