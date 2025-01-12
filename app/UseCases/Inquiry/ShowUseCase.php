<?php

namespace App\UseCases\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use Illuminate\Database\Eloquent\Collection;

class ShowUseCase {
    /**
     * @param \App\Domains\Inquiry\IInquiryRepository $inquiryRepository
     */
    public function __construct(
        private readonly IInquiryRepository $inquiryRepository,
    ) {}

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function __invoke():Collection {
        return $this->inquiryRepository->findAll();
    }
}