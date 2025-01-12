<?php 

namespace App\Domains\Inquiry;

use App\Models\Inquiry as InquiryModel;
use Illuminate\Database\Eloquent\Collection;

interface IInquiryRepository {
    public function find(int $id): InquiryModel;

    public function findAll(): Collection;

    public function create(Inquiry $inquiry): void;

    public function update(Inquiry $inquiry): void;
}