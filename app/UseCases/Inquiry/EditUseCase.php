<?php

namespace app\UseCases\Inquiry;

use app\Domains\Inquiry\IInquiryRepository;
use app\Models\Inquiry;

class EditUseCase
{
    public function __construct(
        private readonly IInquiryRepository $inquiryRepository
    ) {}

    public function __invoke(int $id): ?Inquiry
    {
        return $this->inquiryRepository->find($id);
    }
}
