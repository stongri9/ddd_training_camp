<?php

namespace App\UseCases\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use App\Models\Inquiry;

class EditUseCase
{
    /**
     * @param IInquiryRepository $inquiryRepository
     */
    public function __construct(
        private readonly IInquiryRepository $inquiryRepository
    ) {}

    /**
     * @param int $id
     * @return Inquiry|null
     */
    public function __invoke(int $id): ?Inquiry
    {
        return $this->inquiryRepository->find($id);
    }
}
