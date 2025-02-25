<?php

namespace App\UseCases\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use Illuminate\Database\Eloquent\Collection;

class ShowUseCase
{
    public function __construct(
        private readonly IInquiryRepository $inquiryRepository,
    ) {}

    public function __invoke(): Collection
    {
        return $this->inquiryRepository->findAll();
    }
}
