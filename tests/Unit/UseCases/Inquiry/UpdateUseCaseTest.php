<?php

namespace Tests\Unit\UseCases\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use App\Models\Inquiry as InquiryModel;
use App\UseCases\Inquiry\UpdateUseCase;
use App\UseCases\Inquiry\UpdateUseCaseDto;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UpdateUseCaseTest extends TestCase
{
    private int $id = 1;

    private string $lastName = '山田';

    private string $firstName = '太郎';

    private string $tel = '09012345678';

    private string $zipCode = '1234567';

    private string $address = '東京都渋谷区';

    private string $content = 'お問い合わせ内容';

    public function test_update_inquiry_success(): void
    {
        $model = $this->createInquiryModel();

        $repository = $this->createMock(IInquiryRepository::class);
        $repository->expects($this->once())
            ->method('find')
            ->with($this->id)
            ->willReturn($model);
        $repository->expects($this->once())
            ->method('update');

        $useCase = new UpdateUseCase($repository);
        $dto = UpdateUseCaseDto::create(
            $this->id,
            '鈴木',
            '花子',
            '08098765432',
            '9876543',
            '大阪府大阪市',
            '更新後のお問い合わせ内容',
        );

        $useCase($dto);
    }

    public function test_update_inquiry_not_found(): void
    {
        $repository = $this->createMock(IInquiryRepository::class);
        $repository->expects($this->once())
            ->method('find')
            ->with($this->id)
            ->willReturn(null);
        $repository->expects($this->never())
            ->method('update');

        $useCase = new UpdateUseCase($repository);
        $dto = UpdateUseCaseDto::create(
            $this->id,
            $this->lastName,
            $this->firstName,
            $this->tel,
            $this->zipCode,
            $this->address,
            $this->content,
        );

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('問合せデータが登録されていません');

        $useCase($dto);
    }

    public function test_update_inquiry_with_invalid_tel(): void
    {
        $model = $this->createInquiryModel();

        $repository = $this->createMock(IInquiryRepository::class);
        $repository->expects($this->once())
            ->method('find')
            ->with($this->id)
            ->willReturn($model);
        $repository->expects($this->never())
            ->method('update');

        $useCase = new UpdateUseCase($repository);
        $dto = UpdateUseCaseDto::create(
            $this->id,
            $this->lastName,
            $this->firstName,
            '090-1234-5678', // 不正な電話番号
            $this->zipCode,
            $this->address,
            $this->content,
        );

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('電話番号の形式が不正です。');

        $useCase($dto);
    }

    private function createInquiryModel(): InquiryModel
    {
        $model = new InquiryModel;
        $model->id = $this->id;
        $model->last_name = $this->lastName;
        $model->first_name = $this->firstName;
        $model->tel = $this->tel;
        $model->zip_code = $this->zipCode;
        $model->address = $this->address;
        $model->content = $this->content;

        return $model;
    }
}
