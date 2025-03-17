<?php

namespace Tests\Factories;

use app\Domains\User\Role;
use app\Domains\User\User;

class UserTestFactory
{
    /**
     * テスト用のUserエンティティを作成
     */
    public static function create(
        int $id = 1,
        Role $role = Role::HeadNurse,
    ): User {
        return User::reconstruct($id, $role);
    }

    /**
     * テスト用のユーザーコレクションを作成
     *
     * @return \Illuminate\Support\Collection<int, User>
     */
    public static function createTestUsers(): \Illuminate\Support\Collection
    {
        return collect([
            // 看護師 - 日勤、遅番、夜勤に十分な数を確保
            self::create(1, Role::Nurse),
            self::create(2, Role::Nurse),
            self::create(3, Role::Nurse),
            self::create(4, Role::Nurse),
            self::create(5, Role::Nurse),
            self::create(6, Role::Nurse),

            // 准看護師 - 日勤、遅番に十分な数を確保
            self::create(7, Role::AssociateNurse),
            self::create(8, Role::AssociateNurse),
            self::create(9, Role::AssociateNurse),
            self::create(10, Role::AssociateNurse),

            // 看護師長、主任、パート - 夜勤に入れない役割
            self::create(11, Role::HeadNurse),
            self::create(12, Role::Chief),
            self::create(13, Role::Part),

            // アルバイト - 日勤、遅番に入れない役割
            self::create(14, Role::Arbeit),
            self::create(15, Role::Arbeit),

            // 追加の看護師と准看護師 - 予備
            self::create(16, Role::Nurse),
            self::create(17, Role::Nurse),
            self::create(18, Role::AssociateNurse),
            self::create(19, Role::AssociateNurse),
            self::create(20, Role::Nurse),
        ]);
    }
}
