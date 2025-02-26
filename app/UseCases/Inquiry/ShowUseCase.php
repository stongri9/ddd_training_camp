<?php

namespace App\UseCases\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use Illuminate\Database\Eloquent\Collection;

class ShowUseCase
{
    /**
     * @param IInquiryRepository $inquiryRepository
     */
    public function __construct(
        private readonly IInquiryRepository $inquiryRepository,
    ) {}

    /**
     * @return Collection<int, \App\Models\Inquiry>
     */
    public function __invoke(): Collection
    {
        return $this->inquiryRepository->findAll();
    }
}
