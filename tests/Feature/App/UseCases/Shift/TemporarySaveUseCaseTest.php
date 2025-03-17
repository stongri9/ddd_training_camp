<?php

namespace tests\Feature\App\UseCases\Shift;

use app\Domains\User\Role;
use app\Models\User as UserModel;
use app\UseCases\Shift\TemporarySaveUseCase;
use app\UseCases\Shift\TemporarySaveUseCaseDto;
use DateTimeImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TemporarySaveUseCaseTest extends TestCase
{
    use RefreshDatabase;

    private array $users = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->createUsers();
    }

    private function createUsers(): void
    {
        // 看護師長
        $this->users['headNurses'] = UserModel::factory()->count(1)->create([
            'role' => Role::HeadNurse->value,
        ]);

        // チーフ
        $this->users['chiefs'] = UserModel::factory()->count(1)->create([
            'role' => Role::Chief->value,
        ]);

        // 看護師
        $this->users['nurses'] = UserModel::factory()->count(10)->create([
            'role' => Role::Nurse->value,
        ]);

        // 准看護師
        $this->users['associateNurses'] = UserModel::factory()->count(6)->create([
            'role' => Role::AssociateNurse->value,
        ]);

        // アルバイト
        $this->users['arbeits'] = UserModel::factory()->count(3)->create([
            'role' => Role::Arbeit->value,
        ]);

        // パート
        $this->users['parts'] = UserModel::factory()->count(3)->create([
            'role' => Role::Part->value,
        ]);
    }

    #[Test]
    public function ユースケースを実行すると、シフトがテーブルに保存される(): void
    {
        // Arrange
        $dtos = [
            // 1週目
            // 月曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-03'),
                dayShiftUserIds: [
                    $this->users['headNurses'][0]->id,  // 看護師長
                    $this->users['chiefs'][0]->id,      // チーフ
                    $this->users['nurses'][0]->id,      // 看護師
                    $this->users['nurses'][1]->id,      // 看護師
                    $this->users['associateNurses'][0]->id,  // 准看護師
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][2]->id,      // 看護師
                    $this->users['nurses'][3]->id,      // 看護師
                    $this->users['associateNurses'][1]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][4]->id,      // 看護師
                    $this->users['nurses'][5]->id,      // 看護師
                    $this->users['associateNurses'][2]->id,  // 准看護師
                ],
            ),
            // 火曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-04'),
                dayShiftUserIds: [
                    $this->users['nurses'][6]->id,      // 看護師
                    $this->users['nurses'][7]->id,      // 看護師
                    $this->users['associateNurses'][3]->id,  // 准看護師
                    $this->users['parts'][0]->id,       // パート
                    $this->users['associateNurses'][4]->id,  // 准看護師
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][8]->id,      // 看護師
                    $this->users['nurses'][9]->id,      // 看護師
                    $this->users['associateNurses'][5]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][0]->id,      // 看護師
                    $this->users['nurses'][1]->id,      // 看護師
                    $this->users['associateNurses'][0]->id,  // 准看護師
                ],
            ),
            // 水曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-05'),
                dayShiftUserIds: [
                    $this->users['headNurses'][0]->id,  // 看護師長
                    $this->users['nurses'][2]->id,      // 看護師
                    $this->users['nurses'][3]->id,      // 看護師
                    $this->users['parts'][1]->id,       // パート
                    $this->users['associateNurses'][5]->id,  // 准看護師
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][4]->id,      // 看護師
                    $this->users['nurses'][5]->id,      // 看護師
                    $this->users['associateNurses'][1]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][6]->id,      // 看護師
                    $this->users['nurses'][7]->id,      // 看護師
                    $this->users['associateNurses'][2]->id,  // 准看護師
                ],
            ),
            // 木曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-06'),
                dayShiftUserIds: [
                    $this->users['chiefs'][0]->id,      // チーフ
                    $this->users['nurses'][8]->id,      // 看護師
                    $this->users['nurses'][9]->id,      // 看護師
                    $this->users['parts'][2]->id,       // パート
                    $this->users['associateNurses'][3]->id,  // 准看護師
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][0]->id,      // 看護師
                    $this->users['nurses'][1]->id,      // 看護師
                    $this->users['associateNurses'][4]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][2]->id,      // 看護師
                    $this->users['nurses'][3]->id,      // 看護師
                    $this->users['associateNurses'][5]->id,  // 准看護師
                ],
            ),
            // 金曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-07'),
                dayShiftUserIds: [
                    $this->users['headNurses'][0]->id,  // 看護師長
                    $this->users['nurses'][4]->id,      // 看護師
                    $this->users['nurses'][5]->id,      // 看護師
                    $this->users['associateNurses'][0]->id,  // 准看護師
                    $this->users['parts'][0]->id,       // パート
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][6]->id,      // 看護師
                    $this->users['nurses'][7]->id,      // 看護師
                    $this->users['associateNurses'][1]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][8]->id,      // 看護師
                    $this->users['nurses'][9]->id,      // 看護師
                    $this->users['associateNurses'][2]->id,  // 准看護師
                ],
            ),
            // 土曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-08'),
                dayShiftUserIds: [
                    $this->users['chiefs'][0]->id,      // チーフ
                    $this->users['nurses'][0]->id,      // 看護師
                    $this->users['nurses'][1]->id,      // 看護師
                    $this->users['associateNurses'][3]->id,  // 准看護師
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][2]->id,      // 看護師
                    $this->users['nurses'][3]->id,      // 看護師
                    $this->users['associateNurses'][4]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][4]->id,      // 看護師
                    $this->users['nurses'][5]->id,      // 看護師
                    $this->users['associateNurses'][5]->id,  // 准看護師
                ],
            ),
            // 日曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-09'),
                dayShiftUserIds: [
                    $this->users['nurses'][6]->id,      // 看護師
                    $this->users['nurses'][7]->id,      // 看護師
                    $this->users['associateNurses'][0]->id,  // 准看護師
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][8]->id,      // 看護師
                    $this->users['nurses'][9]->id,      // 看護師
                    $this->users['associateNurses'][1]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][0]->id,      // 看護師
                    $this->users['nurses'][1]->id,      // 看護師
                    $this->users['associateNurses'][2]->id,  // 准看護師
                ],
            ),

            // 2週目
            // 月曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-10'),
                dayShiftUserIds: [
                    $this->users['headNurses'][0]->id,  // 看護師長
                    $this->users['nurses'][2]->id,      // 看護師
                    $this->users['nurses'][3]->id,      // 看護師
                    $this->users['associateNurses'][3]->id,  // 准看護師
                    $this->users['parts'][1]->id,       // パート
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][4]->id,      // 看護師
                    $this->users['nurses'][5]->id,      // 看護師
                    $this->users['associateNurses'][4]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][6]->id,      // 看護師
                    $this->users['nurses'][7]->id,      // 看護師
                    $this->users['associateNurses'][5]->id,  // 准看護師
                ],
            ),
            // 火曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-11'),
                dayShiftUserIds: [
                    $this->users['chiefs'][0]->id,      // チーフ
                    $this->users['nurses'][8]->id,      // 看護師
                    $this->users['nurses'][9]->id,      // 看護師
                    $this->users['associateNurses'][0]->id,  // 准看護師
                    $this->users['associateNurses'][1]->id,  // 准看護師
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][2]->id,      // 看護師
                    $this->users['nurses'][3]->id,      // 看護師
                    $this->users['associateNurses'][2]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][4]->id,      // 看護師
                    $this->users['nurses'][5]->id,      // 看護師
                    $this->users['associateNurses'][3]->id,  // 准看護師
                ],
            ),
            // 水曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-12'),
                dayShiftUserIds: [
                    $this->users['headNurses'][0]->id,  // 看護師長
                    $this->users['nurses'][0]->id,      // 看護師
                    $this->users['nurses'][1]->id,      // 看護師
                    $this->users['associateNurses'][4]->id,  // 准看護師
                    $this->users['parts'][2]->id,       // パート
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][6]->id,      // 看護師
                    $this->users['nurses'][7]->id,      // 看護師
                    $this->users['associateNurses'][5]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][8]->id,      // 看護師
                    $this->users['nurses'][9]->id,      // 看護師
                    $this->users['associateNurses'][0]->id,  // 准看護師
                ],
            ),
            // 木曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-13'),
                dayShiftUserIds: [
                    $this->users['chiefs'][0]->id,      // チーフ
                    $this->users['nurses'][2]->id,      // 看護師
                    $this->users['nurses'][3]->id,      // 看護師
                    $this->users['associateNurses'][1]->id,  // 准看護師
                    $this->users['associateNurses'][2]->id,  // 准看護師
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][4]->id,      // 看護師
                    $this->users['nurses'][5]->id,      // 看護師
                    $this->users['associateNurses'][3]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][6]->id,      // 看護師
                    $this->users['nurses'][7]->id,      // 看護師
                    $this->users['associateNurses'][4]->id,  // 准看護師
                ],
            ),
            // 金曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-14'),
                dayShiftUserIds: [
                    $this->users['headNurses'][0]->id,  // 看護師長
                    $this->users['nurses'][0]->id,      // 看護師
                    $this->users['nurses'][1]->id,      // 看護師
                    $this->users['associateNurses'][5]->id,  // 准看護師
                    $this->users['parts'][0]->id,       // パート
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][8]->id,      // 看護師
                    $this->users['nurses'][9]->id,      // 看護師
                    $this->users['associateNurses'][0]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][2]->id,      // 看護師
                    $this->users['nurses'][3]->id,      // 看護師
                    $this->users['associateNurses'][1]->id,  // 准看護師
                ],
            ),
            // 土曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-15'),
                dayShiftUserIds: [
                    $this->users['chiefs'][0]->id,      // チーフ
                    $this->users['nurses'][4]->id,      // 看護師
                    $this->users['nurses'][5]->id,      // 看護師
                    $this->users['associateNurses'][2]->id,  // 准看護師
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][6]->id,      // 看護師
                    $this->users['nurses'][7]->id,      // 看護師
                    $this->users['associateNurses'][3]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][8]->id,      // 看護師
                    $this->users['nurses'][9]->id,      // 看護師
                    $this->users['associateNurses'][4]->id,  // 准看護師
                ],
            ),
            // 日曜日
            TemporarySaveUseCaseDto::create(
                date: new DateTimeImmutable('2025-03-16'),
                dayShiftUserIds: [
                    $this->users['nurses'][0]->id,      // 看護師
                    $this->users['nurses'][1]->id,      // 看護師
                    $this->users['associateNurses'][5]->id,  // 准看護師
                ],
                lateShiftUserIds: [
                    $this->users['nurses'][4]->id,      // 看護師
                    $this->users['nurses'][5]->id,      // 看護師
                    $this->users['associateNurses'][0]->id,  // 准看護師
                ],
                nightShiftUserIds: [
                    $this->users['nurses'][6]->id,      // 看護師
                    $this->users['nurses'][7]->id,      // 看護師
                    $this->users['associateNurses'][1]->id,  // 准看護師
                ],
            ),
        ];

        // Act
        $useCase = $this->app->make(TemporarySaveUseCase::class);
        $useCase($dtos);

        // Assert
        foreach ($dtos as $dto) {
            $this->assertDatabaseHas('shifts', [
                'date' => $dto->date->format('Y-m-d'),
            ]);
        }
    }
}
