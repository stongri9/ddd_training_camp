<?php 

namespace App\Domains\Inquiry;

use App\Models\Inquiry as InquiryModel;

interface IInquiryRepository {
    public function find(int $id): InquiryModel;

    public function create(Inquiry $inquiry): void;

    public function update(Inquiry $inquiry): void;
}