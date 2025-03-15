<?php

namespace app\Domains\Inquiry;

use App\Models\Inquiry as InquiryModel;

interface IInquiryRepository
{
    public function find(int $id): ?InquiryModel;

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, InquiryModel>
     */
    public function findAll(): \Illuminate\Database\Eloquent\Collection;

    public function create(Inquiry $inquiry): void;

    /**
     * @throws \Exception
     */
    public function update(Inquiry $inquiry): void;
}
