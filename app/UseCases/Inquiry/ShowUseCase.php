<?php

namespace app\UseCases\Inquiry;

use app\Domains\Inquiry\IInquiryRepository;
use Illuminate\Database\Eloquent\Collection;

class ShowUseCase
{
    public function __construct(
        private readonly IInquiryRepository $inquiryRepository,
    ) {}

    /**
     * @return Collection<int, \app\Models\Inquiry>
     */
    public function __invoke(): Collection
    {
        return $this->inquiryRepository->findAll();
    }
}
