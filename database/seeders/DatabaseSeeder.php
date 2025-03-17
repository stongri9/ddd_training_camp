<?php

namespace Database\Seeders;

use app\Domains\User\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use app\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->count(60)
            ->sequence(
                ['role' => Role::HeadNurse->value],
                ['role' => Role::Chief->value],
                ['role' => Role::Nurse->value],
                ['role' => Role::AssociateNurse->value],
                ['role' => Role::Part->value],
                ['role' => Role::Arbeit->value],
            )
            ->create();

        User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);

        DB::table('shifts')->insert([
            [
                'date' => '2025-01-13',
            ],
            [
                'date' => '2025-01-14',
            ],
        ]
        );
    }
}
