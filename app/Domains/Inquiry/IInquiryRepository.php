<?php

namespace App\Domains\Inquiry;

use App\Models\Inquiry as InquiryModel;
use Illuminate\Database\Eloquent\Collection;

interface IInquiryRepository
{
    /**
     * @param int $id
     * @return InquiryModel|null
     */
    public function find(int $id): ?InquiryModel;

    /**
     * @return Collection<int, InquiryModel>
     */
    public function findAll(): Collection;

    /**
     * @param Inquiry $inquiry
     * @return void
     */
    public function create(Inquiry $inquiry): void;

    /**
     * @param Inquiry $inquiry
     * @return void
     */
    public function update(Inquiry $inquiry): void;
}
