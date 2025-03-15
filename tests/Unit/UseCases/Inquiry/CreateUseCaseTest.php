<?php

namespace Tests\Unit\UseCases\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use App\UseCases\Inquiry\CreateUseCase;
use App\UseCases\Inquiry\CreateUseCaseDto;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CreateUseCaseTest extends TestCase
{
    private string $lastName = '山田';
    private string $firstName = '太郎';
    private string $tel = '09012345678';
    private string $zipCode = '1234567';
    private string $address = '東京都渋谷区';
    private string $content = 'お問い合わせ内容';

    public function test_create_inquiry_success(): void
    {
        $repository = $this->createMock(IInquiryRepository::class);
        $repository->expects($this->once())
            ->method('create');

        $useCase = new CreateUseCase($repository);
        $dto = CreateUseCaseDto::create(
            $this->lastName,
            $this->firstName,
            $this->tel,
            $this->zipCode,
            $this->address,
            $this->content,
        );

        $useCase($dto);
    }

    public function test_create_inquiry_with_invalid_tel(): void
    {
        $repository = $this->createMock(IInquiryRepository::class);
        $repository->expects($this->never())
            ->method('create');

        $useCase = new CreateUseCase($repository);
        $dto = CreateUseCaseDto::create(
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

    public function test_create_inquiry_with_invalid_zip_code(): void
    {
        $repository = $this->createMock(IInquiryRepository::class);
        $repository->expects($this->never())
            ->method('create');

        $useCase = new CreateUseCase($repository);
        $dto = CreateUseCaseDto::create(
            $this->lastName,
            $this->firstName,
            $this->tel,
            '123-4567', // 不正な郵便番号
            $this->address,
            $this->content,
        );

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('郵便番号の値が不正です。');

        $useCase($dto);
    }
} 