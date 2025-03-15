<?php

namespace Tests\Unit\UseCases\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use App\Models\Inquiry as InquiryModel;
use App\UseCases\Inquiry\ShowUseCase;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;

class ShowUseCaseTest extends TestCase
{
    public function test_show_inquiries(): void
    {
        $model = new InquiryModel;
        $model->id = 1;
        $model->last_name = '山田';
        $model->first_name = '太郎';
        $model->tel = '09012345678';
        $model->zip_code = '1234567';
        $model->address = '東京都渋谷区';
        $model->content = 'お問い合わせ内容';

        $collection = new Collection([$model]);

        $repository = $this->createMock(IInquiryRepository::class);
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($collection);

        $useCase = new ShowUseCase($repository);
        $result = $useCase();

        $this->assertSame(1, $result->count());
        $this->assertSame($model, $result->first());
    }
}
