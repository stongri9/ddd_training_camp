<?php

namespace App\UseCases\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use App\Domains\Inquiry\Inquiry;

class CreateUseCase {
    public function __construct(
        private readonly IInquiryRepository $inquiryRepository,
    ) {}

    public function __invoke(CreateUseCaseDto $createUseCaseDto): void
    {
        try {
            $inquiry = Inquiry::create(
                $createUseCaseDto->last_name,
                $createUseCaseDto->first_name,
                $createUseCaseDto->tel,
                $createUseCaseDto->zip_code,
                $createUseCaseDto->address,
                $createUseCaseDto->content,
            );
            $this->inquiryRepository->create($inquiry);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}