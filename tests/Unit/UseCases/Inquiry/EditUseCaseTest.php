<?php

namespace Tests\Unit\UseCases\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use App\Models\Inquiry as InquiryModel;
use App\UseCases\Inquiry\EditUseCase;
use PHPUnit\Framework\TestCase;

class EditUseCaseTest extends TestCase
{
    public function test_edit_inquiry_found(): void
    {
        $id = 1;
        $model = new InquiryModel;
        $model->id = $id;
        $model->last_name = '山田';
        $model->first_name = '太郎';
        $model->tel = '09012345678';
        $model->zip_code = '1234567';
        $model->address = '東京都渋谷区';
        $model->content = 'お問い合わせ内容';

        $repository = $this->createMock(IInquiryRepository::class);
        $repository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($model);

        $useCase = new EditUseCase($repository);
        $result = $useCase($id);

        $this->assertSame($model, $result);
    }

    public function test_edit_inquiry_not_found(): void
    {
        $id = 999;

        $repository = $this->createMock(IInquiryRepository::class);
        $repository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn(null);

        $useCase = new EditUseCase($repository);
        $result = $useCase($id);

        $this->assertNull($result);
    }
}
