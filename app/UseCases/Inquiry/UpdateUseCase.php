<?php

namespace App\UseCases\Inquiry;

use App\Domains\Inquiry\IInquiryRepository;
use App\Domains\Inquiry\Inquiry;

class UpdateUseCase {
    public function __construct(
        private readonly IInquiryRepository $inquiryRepository,
    )
    {}

    public function __invoke(UpdateUseCaseDto $updateUseCaseDto): void
    {
        $model = $this->inquiryRepository->find($updateUseCaseDto->id);

        try {
            $inquiry = Inquiry::recontract(
                $model->id,
                $model->last_name,
                $model->first_name,
                $model->tel,
                $model->zip_code,
                $model->address,
                $model->content,
            );
            $inquiry->update(
                $updateUseCaseDto->last_name,
                $updateUseCaseDto->first_name,
                $updateUseCaseDto->tel,
                $updateUseCaseDto->zip_code,
                $updateUseCaseDto->address,
                $updateUseCaseDto->content,
            );
            $this->inquiryRepository->update($inquiry);
        } catch (\Exception $e) {
            throw new $e;
        }
    }
}